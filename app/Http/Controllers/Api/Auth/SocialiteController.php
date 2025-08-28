<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mixins\Logs\UserLoginHistoryMixin;
use Exception;
use App\User;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        Log::info('Google authentication initiated');
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        Log::info('Google callback initiated', ['request' => $request->all()]);

        // Validate request parameters
        validateParam($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'id' => 'required',
        ]);

        Log::info('Request parameters validated');

        $data = $request->all();
        $device_id = $data['device_id'];
        $device_type = $data['device_type'];

        // Find user by Google ID or email
        $user = User::where('google_id', $data['id'])
            ->orWhere('email', $data['email'])
            ->first();

        if ($user) {
            Log::info('User found', ['user_id' => $user->id]);

            // Check if device_id matches
            if (!empty($user->device_id) && $user->device_id !== $device_id) {
                Log::warning('Device ID mismatch', ['user_id' => $user->id, 'request_device_id' => $device_id, 'stored_device_id' => $user->device_id]);
                return apiResponse2(0, 'device_mismatch', trans('api.auth.device_mismatch'), []);
            }

            // If device_id is empty, update it with the new one
            if (empty($user->device_id)) {
                $user->update(['device_id' => $device_id]);
                Log::info('Device ID updated', ['user_id' => $user->id, 'device_id' => $device_id]);
            }

            $registered = true;
        } else {
            Log::info('User not found, creating new user');
            $registered = false;

            // Create new user
            $user = User::create([
                'full_name' => $data['name'],
                'email' => $data['email'],
                'google_id' => $data['id'],
                'role_id' => Role::getUserRoleId(),
                'role_name' => Role::$user,
                'status' => User::$active,
                'verified' => true,
                'created_at' => time(),
                'password' => null,
                'device_id' => $device_id, // Set device_id for new users
            ]);
            Log::info('New user created', ['user_id' => $user->id]);
        }

        // Prepare response data
        $responseData = [
            'user_id' => $user->id,
            'already_registered' => $registered,
        ];

        // Update user with Google ID
        $user->update(['google_id' => $data['id']]);
        Log::info('User updated with Google ID', ['user_id' => $user->id]);

        // Generate token for the user
        $token = auth('api')->tokenById($user->id);
        $responseData['token'] = $token;
        Log::info('Token generated for user', ['user_id' => $user->id, 'token' => $token]);

        // Store user login history
        $userLoginHistoryMixin = new UserLoginHistoryMixin();
        $userLoginHistoryMixin->storeUserLoginHistory($user, $device_type);
        Log::info('User login history stored', ['user_id' => $user->id]);

        return apiResponse2(1, $registered ? 'login' : 'registered', trans('api.auth.' . ($registered ? 'login' : 'registered')), $responseData);
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        Log::info('Facebook callback initiated', ['request' => $request->all()]);

        // Validate request parameters
        validateParam($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'id' => 'required',
            'device_id' => 'required', // Ensure device_id is included
        ]);

        Log::info('Request parameters validated');

        $data = $request->all();
        $device_id = $data['device_id'];

        // Find user by Facebook ID or email
        $user = User::where('facebook_id', $data['id'])
            ->orWhere('email', $data['email'])
            ->first();

        $registered = true;

        if (empty($user)) {
            Log::info('User not found, creating new user');
            $registered = false;

            // Create new user
            $user = User::create([
                'full_name' => $data['name'],
                'email' => $data['email'],
                'facebook_id' => $data['id'],
                'role_id' => Role::getUserRoleId(),
                'role_name' => Role::$user,
                'status' => User::$active,
                'verified' => true,
                'created_at' => time(),
                'password' => null,
                'device_id' => $device_id, // Set device_id for new users
            ]);
            Log::info('New user created', ['user_id' => $user->id]);
        } else {
            Log::info('User found', ['user_id' => $user->id]);

            // Check if device_id matches
            if (!empty($user->device_id) && $user->device_id !== $device_id) {
                Log::warning('Device ID mismatch', ['user_id' => $user->id, 'request_device_id' => $device_id, 'stored_device_id' => $user->device_id]);
                return apiResponse2(0, 'device_mismatch', trans('api.auth.device_mismatch'), []);
            }

            // If device_id is empty, update it with the new one
            if (empty($user->device_id)) {
                $user->update(['device_id' => $device_id]);
                Log::info('Device ID updated', ['user_id' => $user->id, 'device_id' => $device_id]);
            }
        }

        // Prepare response data
        $responseData = [
            'user_id' => $user->id,
            'already_registered' => $registered,
        ];

        // Generate token for the user
        if ($registered) {
            $token = auth('api')->tokenById($user->id);
            $responseData['token'] = $token;
            Log::info('Token generated for existing user', ['user_id' => $user->id, 'token' => $token]);

            return apiResponse2(1, 'login', trans('api.auth.login'), $responseData);
        }

        return apiResponse2(1, 'registered', trans('api.auth.registered'), $responseData);
    }
}
