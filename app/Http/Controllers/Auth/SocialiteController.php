<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\User;
use App\Mixins\Logs\UserLoginHistoryMixin;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class SocialiteController extends Controller
{
    public function __construct()
    {
        $settings = getFeaturesSettings();
        $agent = new Agent();
        // Retrieve the User-Agent string
        $userAgentString = $agent->getUserAgent();

        // Fetch MAC address from the User-Agent
        $macAddress = $this->getMacAddress($userAgentString); // This will retrieve the MAC address

        // Logging the settings and User-Agent for debugging
        Log::info('SocialiteController initialized.', [
            'google_client_id' => $settings['google_client_id'] ?? 'N/A',
            'facebook_client_id' => $settings['facebook_client_id'] ?? 'N/A',
            'user_agent' => $userAgentString,
            'mac_address' => $macAddress
        ]);

        \Config::set('services.google.client_id', !empty($settings['google_client_id']) ? $settings['google_client_id'] : '');
        \Config::set('services.google.client_secret', !empty($settings['google_client_secret']) ? $settings['google_client_secret'] : '');
        \Config::set('services.google.redirect', url("/google/callback"));

        \Config::set('services.facebook.client_id', !empty($settings['facebook_client_id']) ? $settings['facebook_client_id'] : '');
        \Config::set('services.facebook.client_secret', !empty($settings['facebook_client_secret']) ? $settings['facebook_client_secret'] : '');
        \Config::set('services.facebook.redirect', url("/facebook/callback"));
    }

    protected function getMacAddress($userAgent)
    {
        // Look for the position of '(MAC: ' in the User-Agent string
        $start = strpos($userAgent, '(MAC: ');

        // If the '(MAC: ' substring is found
        if ($start !== false) {
            $macSubstring = substr($userAgent, $start);
            $end = strpos($macSubstring, ')');

            if ($end !== false) {
                $macAddress = trim(substr($macSubstring, 6, $end - 6));
                Log::info('MAC Address extracted', ['mac_address' => $macAddress]); // Log the MAC address
                return $macAddress;
            }
        }

        Log::warning('MAC Address not found in the User-Agent', ['user_agent' => $userAgent]);
        return null;
    }

    public function redirectToGoogle()
    {
        Log::info('Redirecting to Google login.');
        return Socialite::driver('google')->redirect();
    }

    private function getLocationByIp($ip)
    {
        Log::info('Fetching location data by IP', ['ip' => $ip]);
        $response = file_get_contents("https://ipinfo.io/{$ip}/json");
        return json_decode($response, true);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $userIp = request()->ip(); // Get the user's IP address
            Log::info('User IP Address', ['ip' => $userIp]);

            $locationData = $this->getLocationByIp($userIp);
            Log::info('Location data retrieved', ['location_data' => $locationData]);

            $currency = 'USD'; // Default currency

            if (!empty($locationData['country']) && $locationData['country'] === 'EG') { // Check if country code is Egypt
                $currency = 'EGP';
            }

            $account = Socialite::driver('google')->user();
            Log::info('Google account data retrieved', ['account' => $account]);

            $user = User::where('google_id', $account->id)
                ->orWhere('email', $account->email)
                ->first();
            Log::info('User lookup result', ['user' => $user]);

            $macAddress = $this->getMacAddress($request->header('User-Agent'));
            Log::info('MAC Address used for validation', ['mac_address' => $macAddress]);

            if (empty($user)) {
                Log::info('No existing user found, creating a new user.');

                $user = User::create([
                    'full_name' => $account->name,
                    'email' => $account->email,
                    'google_id' => $account->id,
                    'role_id' => Role::getUserRoleId(),
                    'role_name' => Role::$user,
                    'status' => User::$active,
                    'verified' => false,
                    'created_at' => time(),
                    'currency' => $currency, // Store the determined currency
                    'mac_address' => $macAddress, // Store the MAC address
                    'password' => null
                ]);
                Log::info('New user created', ['user_id' => $user->id]);
            } else {
    Log::info('User found, validating security settings and MAC address.');

    $securitySettings = getGeneralSecuritySettings();
    $restrictSpecificDevice = !empty($securitySettings['restrict_specific_device']) ? $securitySettings['restrict_specific_device'] : 0;

    if ($restrictSpecificDevice == "1") {
        Log::info('Specific device restriction enabled, validating MAC address.');

        if ($user->mac_address) {
            if ($macAddress !== $user->mac_address && $macAddress !== null) {
                Log::warning('MAC address mismatch', [
                    'stored_mac_address' => $user->mac_address,
                    'provided_mac_address' => $macAddress
                ]);
                return $this->sendDifferentDeviceResponse();
            }
        } else {
            $user->update(['mac_address' => $macAddress]);
            Log::info('MAC Address updated for user', ['user_id' => $user->id]);
        }
    }

    $checkLoginDeviceLimit = $this->checkLoginDeviceLimit($user);
    Log::info('Device limit check result', ['result' => $checkLoginDeviceLimit]);

    if ($checkLoginDeviceLimit != "ok") {
        Log::info('Device limit reached, logging out user.');
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return $this->sendMaximumActiveSessionResponse();
    }
}

            // Proceed with login
            $user->update(['google_id' => $account->id]);
            Auth::login($user);
            Log::info('User logged in', ['user_id' => $user->id]);

            // Store login history
            $userLoginHistoryMixin = new UserLoginHistoryMixin();
            $userLoginHistoryMixin->storeUserLoginHistory($user);
            Log::info('User login history stored', ['user_id' => $user->id]);

            return redirect('/');
        } catch (Exception $e) {
            Log::error('Error during Google login callback', ['exception' => $e]);

            $toastData = [
                'title' => trans('public.request_failed'),
                'msg' => trans('auth.fail_login_by_google'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }
    }

    public function redirectToFacebook()
    {
        Log::info('Redirecting to Facebook login.');
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        try {
            $account = Socialite::driver('facebook')->user();
            Log::info('Facebook account data retrieved', ['account' => $account]);

            $user = User::where('facebook_id', $account->id)->first();
            Log::info('User lookup result for Facebook', ['user' => $user]);

            if (empty($user)) {
                Log::info('No existing user found for Facebook, creating a new user.');

                $user = User::create([
                    'full_name' => $account->name,
                    'email' => $account->email,
                    'facebook_id' => $account->id,
                    'role_id' => Role::getUserRoleId(),
                    'role_name' => Role::$user,
                    'status' => User::$active,
                    'verified' => false,
                    'created_at' => time(),
                    'password' => null
                ]);
                Log::info('New user created for Facebook', ['user_id' => $user->id]);
            } else {
                $checkLoginDeviceLimit = $this->checkLoginDeviceLimit($user);
                Log::info('Device limit check result for Facebook', ['result' => $checkLoginDeviceLimit]);

                if ($checkLoginDeviceLimit != "ok") {
                    Log::info('Device limit reached for Facebook, logging out user.');
                    Auth::logout();
                    $request->session()->flush();
                    $request->session()->regenerate();
                    return $this->sendMaximumActiveSessionResponse();
                }
            }

            Auth::login($user);
            Log::info('User logged in via Facebook', ['user_id' => $user->id]);

            $userLoginHistoryMixin = new UserLoginHistoryMixin();
            $userLoginHistoryMixin->storeUserLogoutHistory($user->id);
            Log::info('User logout history stored', ['user_id' => $user->id]);

            return redirect('/');
        } catch (Exception $e) {
            Log::error('Error during Facebook login callback', ['exception' => $e]);

            $toastData = [
                'title' => trans('public.request_failed'),
                'msg' => trans('auth.fail_login_by_facebook'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }
    }

    private function checkLoginDeviceLimit($user)
    {
        $securitySettings = getGeneralSecuritySettings();
        Log::info('Security settings retrieved', ['security_settings' => $securitySettings]);

        if (!empty($securitySettings) && !empty($securitySettings['login_device_limit'])) {
            $limitCount = !empty($securitySettings['number_of_allowed_devices']) ? $securitySettings['number_of_allowed_devices'] : 1;

            $count = $user->logged_count;
            Log::info('Device limit check', ['logged_count' => $count, 'limit' => $limitCount]);

            if ($count >= $limitCount) {
                Log::warning('Device limit exceeded', ['user_id' => $user->id]);
                return "no";
            }
        }

        return 'ok';
    }

    protected function sendMaximumActiveSessionResponse()
    {
        Log::info('Sending maximum active session response.');

        $toastData = [
            'title' => trans('update.login_failed'),
            'msg' => trans('update.device_limit_reached_please_try_again'),
            'status' => 'error'
        ];

        return redirect('/login')->with(['login_failed_active_session' => $toastData]);
    }

    protected function sendDifferentDeviceResponse()
    {
        Log::warning('Sending different device detected response.');

        $toastData = [
            'title' => "Different Device",
            'msg' => "Different Device Detected",
            'status' => 'error'
        ];

        return redirect('/login')->with(['toast' => $toastData]);
    }
}
