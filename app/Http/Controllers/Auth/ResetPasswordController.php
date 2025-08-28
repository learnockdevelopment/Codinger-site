<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token)
    {
        $updatePassword = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $token)
            ->first();

        // Check if the token exists and has not expired
        if (!empty($updatePassword) && Carbon::parse($updatePassword->created_at)->addMinutes(config('auth.passwords.users.expire'))->isFuture()) {
            return view(getTemplate() . '.auth.reset_password', ['token' => $token]);
        }

        abort(404); // Invalid or expired token
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [], [
            'email' => trans('auth.email'),
            'password' => trans('auth.password'),
            'password_confirmation' => trans('auth.password_repeat'),
        ]);

        $data = $request->all();

        $updatePassword = DB::table('password_resets')
            ->where('email', $data['email'])
            ->where('token', $data['token'])
            ->first();

        // Check if the token exists and has not expired
        if (!empty($updatePassword) && Carbon::parse($updatePassword->created_at)->addMinutes(config('auth.passwords.users.expire'))->isFuture()) {
            User::where('email', $data['email'])
                ->update(['password' => Hash::make($data['password'])]);

            // Delete the token after successful reset
            DB::table('password_resets')->where('email', $data['email'])->delete();

            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => trans('auth.reset_password_success'),
                'status' => 'success'
            ];
            return redirect('/login')->with(['toast' => $toastData]);
        }

        // Token invalid or expired
        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => trans('auth.reset_password_token_invalid'),
            'status' => 'error'
        ];
        return back()->withInput()->with(['toast' => $toastData]);
    }
}
