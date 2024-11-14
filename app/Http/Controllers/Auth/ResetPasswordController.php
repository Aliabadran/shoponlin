<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;

class ResetPasswordController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'token' => ['required']
        ]);

        // Reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Automatically log the user in
                Auth::login($user);

                // Notify the user that their password has been changed
                $user->notify(new \App\Notifications\PasswordChangedNotification());
            }
        );

        // Check if the reset was successful
        if ($status == Password::PASSWORD_RESET) {
            Alert::success('Success', 'Password reset link sent! Please check your email.');
            notify()->success('Password reset link sent! Check your email.');
            return redirect()->route('home')->with('status', __($status));
        } else {
            Alert::error('Error', 'Unable to send password reset link.');
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => __($status)]);
        }
    }
}
