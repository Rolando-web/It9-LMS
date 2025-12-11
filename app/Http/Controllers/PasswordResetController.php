<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Show the email form
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Send reset link (modified to bypass email): if email exists, create token and redirect to reset form
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        }

        $token = Password::createToken($user);

        return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email])
            ->with('status', __('Proceed to reset your password.'));
    }

    // Show reset form
    public function showResetForm(Request $request, $token)
    {
        if (empty($token)) {
            return redirect()->route('password.request')->withErrors(['email' => __('Invalid or missing reset token. Please enter your email again.')]);
        }
        return view('auth.passwords.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // Handle password reset
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
