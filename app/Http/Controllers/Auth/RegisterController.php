<?php

namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\traits\UserFormFieldsTrait;
use App\Mixins\RegistrationBonus\RegistrationBonusAccounting;
use App\Models\Affiliate;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\UserMeta;
use App\Models\Category;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Import the Log facade

class RegisterController extends Controller
{

    use UserFormFieldsTrait;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    {
        $seoSettings = getSeoMetas('register');
        $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('site.register_page_title');
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('site.register_page_title');
        $pageRobot = getPageRobot('register');

        $referralSettings = getReferralSettings();

        $referralCode = Cookie::get('referral_code');

        $accountType = !empty($request->old('account_type')) ? $request->old('account_type') : "user";
        $formFields = $this->getFormFieldsByUserType($request, $accountType, true);
      
       $ageRanges = Category::query()
        ->orderBy('age_min')
        ->get()
        ->map(function ($category) {
            return [
                'id' => $category->id,
                'ageRange' => "{$category->age_min}-{$category->age_max}"
            ];
        })
        ->values()
        ->toArray();


        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'referralCode' => $referralCode,
            'referralSettings' => $referralSettings,
            'formFields' => $formFields,
            'ageRanges' => $ageRanges,

        ];

        return view(getTemplate() . '.auth.register', $data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';

        if (!empty($data['mobile']) and !empty($data['country_code'])) {
            $data['mobile'] = ltrim($data['country_code'], '+') . ltrim($data['mobile'], '0');
        }

      
        $rules = [
            'country_code' => ($registerMethod == 'mobile') ? 'required' : 'nullable',
            'mobile' => (($registerMethod == 'mobile') ? 'required' : 'nullable') . '|numeric|unique:users',
            'email' => (($registerMethod == 'email') ? 'required' : 'nullable') . '|email|max:255|unique:users',
            'term' => 'required',
            'full_name' => 'required|string|min:3',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
            'referral_code' => 'nullable|exists:affiliates_codes,code',
			'category_id' => 'required|exists:categories,id' // Validate category ID

        ];
      
      

        if (!empty(getGeneralSecuritySettings('captcha_for_register'))) {
            $rules['captcha'] = 'required|captcha';
        }

        return Validator::make($data, $rules, [], [
            'mobile' => trans('auth.mobile'),
            'email' => trans('auth.email'),
            'term' => trans('update.terms'),
            'full_name' => trans('auth.full_name'),
            'password' => trans('auth.password'),
            'password_confirmation' => trans('auth.password_repeat'),
            'referral_code' => trans('financial.referral_code'),
			'category_id' => trans('validation.category_id'), // Custom validation message

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return
     */
    protected function create(array $data)
{
    // Handle mobile number formatting
    if (!empty($data['mobile']) && !empty($data['country_code'])) {
        $data['mobile'] = ltrim($data['country_code'], '+') . ltrim($data['mobile'], '0');
    }

    // Get the user's IP address
    $userIp = request()->ip(); // Get the user's IP address

    // Use an external API to get location data
    $locationData = $this->getLocationByIp($userIp);
    $currency = 'USD'; // Default currency

    if (!empty($locationData['country']) && $locationData['country'] === 'EG') { // Check if country code is Egypt
            $currency = 'EGP';
        }

    // Log the determined currency (optional)
    Log::info('Determined currency for user', ['currency' => $currency]);

    // Referral settings and user affiliate status
    $referralSettings = getReferralSettings();
    $usersAffiliateStatus = (!empty($referralSettings) && !empty($referralSettings['users_affiliate_status']));

    // Timezone handling
    if (empty($data['timezone'])) {
        $data['timezone'] = getGeneralSettings('default_time_zone') ?? null;
    }

    // Content access settings
    $disableViewContentAfterUserRegister = getFeaturesSettings('disable_view_content_after_user_register');
    $accessContent = !((!empty($disableViewContentAfterUserRegister) && $disableViewContentAfterUserRegister));

    // Role handling
    $roleName = Role::$user;
    $roleId = Role::getUserRoleId();

    if (!empty($data['account_type'])) {
        if ($data['account_type'] == Role::$teacher) {
            $roleName = Role::$teacher;
            $roleId = Role::getTeacherRoleId();
        } elseif ($data['account_type'] == Role::$organization) {
            $roleName = Role::$organization;
            $roleId = Role::getOrganizationRoleId();
        }
    }

    // Create the user
    $user = User::create([
        'role_name' => $roleName,
        'role_id' => $roleId,
        'mobile' => $data['mobile'] ?? null,
        'email' => $data['email'] ?? null,
        'full_name' => $data['full_name'],
        'status' => User::$pending,
        'access_content' => $accessContent,
        'password' => Hash::make($data['password']),
        'affiliate' => $usersAffiliateStatus,
        'timezone' => $data['timezone'] ?? null,
        'currency' => $currency, // Store the determined currency
		'category_id' => $data['category_id'], // Store category ID
        'country_code' => $data['country_code'], // Store the country code
        'created_at' => time(),
    ]);

    // Handle additional certificate data
    if (!empty($data['certificate_additional'])) {
        UserMeta::updateOrCreate([
            'user_id' => $user->id,
            'name' => 'certificate_additional'
        ], [
            'value' => $data['certificate_additional']
        ]);
    }

    // Store additional form fields
    $this->storeFormFields($data, $user);

    return $user;
}

// Function to get location by IP
private function getLocationByIp($ip)
{
    $response = file_get_contents("https://ipinfo.io/{$ip}/json");
    return json_decode($response, true);
}


public function register(Request $request)
{
    Log::debug('Start Register Method');

    $validate = $this->validator($request->all());
    Log::debug('Validation result', ['validate' => $validate->fails()]);

    if ($validate->fails()) {
        $errors = $validate->errors();
        Log::debug('Validation failed', ['errors' => $errors]);

        $form = $this->getFormFieldsByType($request->get('account_type'));
        Log::debug('Form fields by account type', ['form' => $form]);

        if (!empty($form)) {
            $fieldErrors = $this->checkFormRequiredFields($request, $form);
            Log::debug('Field errors from custom check', ['fieldErrors' => $fieldErrors]);

            if (!empty($fieldErrors) and count($fieldErrors)) {
                foreach ($fieldErrors as $id => $error) {
                    $errors->add($id, $error);
                }
            }
        }

        throw new ValidationException($validate);
    } else {
        $form = $this->getFormFieldsByType($request->get('account_type'));
        Log::debug('Form fields by account type (else)', ['form' => $form]);

        $errors = [];

        if (!empty($form)) {
            $fieldErrors = $this->checkFormRequiredFields($request, $form);
            Log::debug('Field errors from custom check (else)', ['fieldErrors' => $fieldErrors]);

            if (!empty($fieldErrors) and count($fieldErrors)) {
                foreach ($fieldErrors as $id => $error) {
                    $errors[$id] = $error;
                }
            }
        }

        if (count($errors)) {
            Log::debug('Returning errors', ['errors' => $errors]);
            return back()->withErrors($errors)->withInput($request->all());
        }
    }

    $data = $request->all();
    Log::debug('Registration data', ['data' => $data]);

    if (!empty($data['mobile']) and !empty($data['country_code'])) {
        $data['mobile'] = $data['country_code'] . ltrim($data['mobile'], '0');
        Log::debug('Formatted mobile number', ['mobile' => $data['mobile']]);
    }

    if (!empty($data['mobile'])) {
        $checkIsValid = checkMobileNumber($data['mobile']);
        Log::debug('Mobile number validation', ['isValid' => $checkIsValid]);

        if (!$checkIsValid) {
            $errors['mobile'] = [trans('update.mobile_number_is_not_valid')];
            Log::debug('Mobile number is not valid', ['errors' => $errors]);
            return back()->withErrors($errors)->withInput($request->all());
        }
    }

    $user = $this->create($request->all());
    Log::debug('User created', ['user' => $user]);

    event(new Registered($user));
    Log::debug('Registered event triggered', ['user' => $user]);

    $notifyOptions = [
        '[u.name]' => $user->full_name,
        '[u.role]' => trans("update.role_{$user->role_name}"),
        '[time.date]' => dateTimeFormat($user->created_at, 'j M Y H:i'),
    ];
    sendNotification("new_registration", $notifyOptions, 1);
    Log::debug('Notification sent', ['notifyOptions' => $notifyOptions]);

    $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
    Log::debug('Register method', ['registerMethod' => $registerMethod]);

    $value = $request->get($registerMethod);
    if ($registerMethod == 'mobile') {
        $value = $request->get('country_code') . ltrim($request->get('mobile'), '0');
        Log::debug('Register method is mobile, formatted value', ['value' => $value]);
    }

    $referralCode = $request->get('referral_code', null);
    if (!empty($referralCode)) {
        session()->put('referralCode', $referralCode);
        Log::debug('Referral code stored in session', ['referralCode' => $referralCode]);
    }

    $verificationController = new VerificationController();
    $checkConfirmed = $verificationController->checkConfirmed($user, $registerMethod, $value);
    Log::debug('Email confirmation check', ['checkConfirmed' => $checkConfirmed]);

    $referralCode = $request->get('referral_code', null);

    if ($checkConfirmed['status'] == 'send') {
        Log::debug('Verification code sent', ['status' => 'send']);

        if (!empty($referralCode)) {
            session()->put('referralCode', $referralCode);
            Log::debug('Referral code stored in session (send)', ['referralCode' => $referralCode]);
        }

        return redirect('/verification');
    } elseif ($checkConfirmed['status'] == 'verified') {
        $this->guard()->login($user);
        Log::debug('User logged in', ['user' => $user]);

        $enableRegistrationBonus = false;
        $registrationBonusAmount = null;
        $registrationBonusSettings = getRegistrationBonusSettings();
        Log::debug('Registration bonus settings', ['registrationBonusSettings' => $registrationBonusSettings]);

        if (!empty($registrationBonusSettings['status']) and !empty($registrationBonusSettings['registration_bonus_amount'])) {
            $enableRegistrationBonus = true;
            $registrationBonusAmount = $registrationBonusSettings['registration_bonus_amount'];
        }

        $user->update([
            'status' => User::$active,
            'enable_registration_bonus' => $enableRegistrationBonus,
            'registration_bonus_amount' => $registrationBonusAmount,
        ]);
        Log::debug('User updated with status and bonus', ['user' => $user]);

        $registerReward = RewardAccounting::calculateScore(Reward::REGISTER);
        RewardAccounting::makeRewardAccounting($user->id, $registerReward, Reward::REGISTER, $user->id, true);
        Log::debug('Registration reward applied', ['registerReward' => $registerReward]);

        if (!empty($referralCode)) {
            Affiliate::storeReferral($user, $referralCode);
            Log::debug('Referral code stored', ['referralCode' => $referralCode]);
        }

        $registrationBonusAccounting = new RegistrationBonusAccounting();
        $registrationBonusAccounting->storeRegistrationBonusInstantly($user);
        Log::debug('Registration bonus stored instantly', ['user' => $user]);

        if ($response = $this->registered($request, $user)) {
            Log::debug('Registered response', ['response' => $response]);
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }
}



}
