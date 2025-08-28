<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mixins\RegistrationBonus\RegistrationBonusAccounting;
use App\Models\Affiliate;
use App\Models\Verification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function index()
    {
        Log::debug('VerificationController@index called');
        
        $verificationId = session()->get('verificationId', null);
        Log::debug('Verification ID from session: ', ['verificationId' => $verificationId]);

        if (!empty($verificationId)) {
            $verification = Verification::where('id', $verificationId)
                ->whereNull('verified_at')
                ->where('expired_at', '>', time())
                ->first();

            Log::debug('Verification record found: ', ['verification' => $verification]);

            if (!empty($verification)) {
                $user = User::find($verification->user_id);
                Log::debug('User found: ', ['user' => $user]);

                if (!empty($user) and $user->status != User::$active) {
                    $data = [
                        'pageTitle' => trans('auth.email_confirmation'),
                        'username' => !empty($verification->mobile) ? 'mobile' : 'email',
                        'usernameValue' => !empty($verification->mobile) ? $verification->mobile : $verification->email,
                    ];

                    Log::debug('Returning verification view with data: ', ['data' => $data]);

                    return view('web.default.auth.verification', $data);
                }
            }
        }

        Log::debug('Redirecting to login page');
        return redirect('/login');
    }

    public function resendCode()
    {
        Log::debug('VerificationController@resendCode called');

        $verificationId = session()->get('verificationId', null);
        Log::debug('Verification ID from session: ', ['verificationId' => $verificationId]);

        if (!empty($verificationId)) {
            $verification = Verification::where('id', $verificationId)
                ->whereNull('verified_at')
                ->where('expired_at', '>', time())
                ->first();

            Log::debug('Verification record found: ', ['verification' => $verification]);

            if (!empty($verification)) {
                if (!empty($verification->mobile)) {
                    $verification->sendSMSCode();
                    Log::debug('SMS code sent');
                } else {
                    $verification->sendEmailCode();
                    Log::debug('Email code sent');
                }

                return redirect('/verification');
            }
        }

        Log::debug('Redirecting to login page');
        return redirect('/login');
    }

    public function checkConfirmed($user, $username, $value)
    {
        Log::debug('VerificationController@checkConfirmed called', compact('user', 'username', 'value'));

        $disableRegistrationVerificationProcess = getGeneralOptionsSettings('disable_registration_verification_process');
        Log::debug('Disable registration verification process: ', ['disableRegistrationVerificationProcess' => $disableRegistrationVerificationProcess]);

        if (!empty($disableRegistrationVerificationProcess)) {
            Log::debug('Skipping verification process, returning verified status');
            return ['status' => 'verified'];
        }

        if (!empty($value)) {
            $verification = Verification::where($username, $value)
                ->where('expired_at', '>', time())
                ->where(function ($query) {
                    $query->whereNull('user_id')
                        ->orWhereHas('user');
                })
                ->first();

            Log::debug('Verification record: ', ['verification' => $verification]);

            $data = [];
            $time = time();

            if (!empty($verification)) {
                if (!empty($verification->verified_at)) {
                    Log::debug('Verification already verified, returning verified status');
                    return ['status' => 'verified'];
                } else {
                    $data['created_at'] = $time;
                    $data['expired_at'] = $time + Verification::EXPIRE_TIME;

                    if (time() > $verification->expired_at) {
                        $data['code'] = $this->getNewCode();
                        Log::debug('Verification expired, generating new code');
                    } else {
                        $data['code'] = $verification->code;
                        Log::debug('Verification code reused');
                    }
                }
            } else {
                $data[$username] = $value;
                $data['code'] = $this->getNewCode();
                $data['user_id'] = !empty($user) ? $user->id : (auth()->check() ? auth()->id() : null);
                $data['created_at'] = $time;
                $data['expired_at'] = $time + Verification::EXPIRE_TIME;
                Log::debug('No verification record found, creating new record', ['data' => $data]);
            }

            $data['verified_at'] = null;

            $verification = Verification::updateOrCreate([$username => $value], $data);

            session()->put('verificationId', $verification->id);
            Log::debug('Verification record saved or updated: ', ['verification' => $verification]);

            if ($username == 'mobile') {
                $verification->sendSMSCode();
                Log::debug('SMS code sent for mobile');
            } else {
                $verification->sendEmailCode();
                Log::debug('Email code sent for email');
            }

            return ['status' => 'send'];
        }

        Log::debug('Abort, verification not found');
        abort(404);
    }

    public function confirmCode(Request $request)
    {
        Log::debug('VerificationController@confirmCode called');

        $value = $request->get('username');
        $code = $request->get('code');
        $username = $this->username($value);
        $request[$username] = $value;
        $time = time();

        Log::debug('Verifying code for username: ', ['value' => $value, 'code' => $code]);

        Verification::where($username, $value)
            ->whereNull('verified_at')
            ->where('code', $code)
            ->where('created_at', '>', $time - 24 * 60 * 60)
            ->update([
                'verified_at' => $time,
                'expired_at' => $time + 50,
            ]);
        Log::debug('Verification code updated for', ['username' => $username, 'value' => $value]);

        $rules = [
            'code' => [
                'required',
                Rule::exists('verifications')->where(function ($query) use ($value, $code, $time, $username) {
                    $query->where($username, $value)
                        ->where('code', $code)
                        ->whereNotNull('verified_at')
                        ->where('expired_at', '>', $time);
                }),
            ],
        ];

        if ($username == 'mobile') {
            $rules['mobile'] = 'required';
            $value = ltrim($value, '+');
            Log::debug('Mobile value processed: ', ['value' => $value]);
        } else {
            $rules['email'] = 'required|email';
            Log::debug('Email value processed: ', ['value' => $value]);
        }

        $this->validate($request, $rules, [], [
            'mobile' => trans('auth.mobile'),
            'email' => trans('auth.email'),
            'code' => trans('auth.code'),
        ]);
        Log::debug('Validation rules passed');

        $authUser = auth()->check() ? auth()->user() : null;
        Log::debug('Authenticated user: ', ['authUser' => $authUser]);

        $referralCode = session()->get('referralCode', null);
        Log::debug('Referral code from session: ', ['referralCode' => $referralCode]);

        if (empty($authUser)) {
            $authUser = User::where($username, $value)->first();
            Log::debug('User found by username value: ', ['authUser' => $authUser]);

            $loginController = new LoginController();

            if (!empty($authUser)) {
                if (\Auth::loginUsingId($authUser->id)) {
                    Log::debug('User logged in successfully');

                    if (!empty($referralCode)) {
                        Affiliate::storeReferral($authUser, $referralCode);
                        Log::debug('Referral code applied');
                    }

                    $enableRegistrationBonus = false;
                    $registrationBonusAmount = null;
                    $registrationBonusSettings = getRegistrationBonusSettings();
                    Log::debug('Registration bonus settings: ', ['registrationBonusSettings' => $registrationBonusSettings]);

                    if (!empty($registrationBonusSettings['status']) and !empty($registrationBonusSettings['registration_bonus_amount'])) {
                        $enableRegistrationBonus = true;
                        $registrationBonusAmount = $registrationBonusSettings['registration_bonus_amount'];
                    }

                    $authUser->update([
                        'enable_registration_bonus' => $enableRegistrationBonus,
                        'registration_bonus_amount' => $registrationBonusAmount,
                    ]);
                    Log::debug('User updated with registration bonus', ['authUser' => $authUser]);

                    $registrationBonusAccounting = new RegistrationBonusAccounting();
                    $registrationBonusAccounting->storeRegistrationBonusInstantly($authUser);
                    Log::debug('Registration bonus stored');

                    return $loginController->afterLogged($request, true);
                }
            }

            return $loginController->sendFailedLoginResponse($request);
        }
    }

    private function username($value)
    {
        Log::debug('Determining username for value: ', ['value' => $value]);

        $username = 'email';
        $email_regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

        if (preg_match($email_regex, $value)) {
            $username = 'email';
        } elseif (is_numeric($value)) {
            $username = 'mobile';
        }

        Log::debug('Username determined: ', ['username' => $username]);
        return $username;
    }

    public function getNewCode()
    {
        $code = rand(10000, 99999);
        Log::debug('Generated new code: ', ['code' => $code]);
        return $code;
    }
}
