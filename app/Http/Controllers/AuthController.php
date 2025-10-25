<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password; // kept but not used in simplified flow
use Illuminate\Validation\ValidationException; // kept for potential future use
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If user is already logged in, redirect to appropriate page
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin' || $user->role === 'super_admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'firstName' => $validated['firstName'],
            'lastName' => $validated['lastName'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Account Created Successfully');
    }

    /**
     * Show the forgot password (reset link request) form
     */
    public function showForgotPasswordForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.forgot-password');
    }

    /**
     * Simplified: verify email exists and proceed to reset form (no email sending)
     */
    public function checkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => "We can't find a user with that email address."])->withInput();
        }

        return redirect()->route('password.reset', ['email' => $user->email])
            ->with('success', 'Email verified. Please set a new password.');
    }

    /**
     * Show the password reset form (simplified, no token)
     */
    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('password.request');
        }
        // Optionally verify email exists before showing form
        $exists = User::where('email', $email)->exists();
        if (!$exists) {
            return redirect()->route('password.request')->withErrors(['email' => 'Invalid or unknown email.']);
        }
        return view('auth.reset-password', ['email' => $email]);
    }

    /**
     * Handle the password reset (simplified, directly updates by email)
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'The passwords do not match.',
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.'])->withInput();
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('login')->with('success', 'Password has been reset successfully.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->intended('dashboard')->with('success', 'Log in Successfully');
            } else if ($user->role === 'super_admin') {
                return redirect()->intended('dashboard')->with('success', 'Log in Successfully');
            } else {
                return redirect()->intended('app')->with('success', 'Log in Successfully');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        if ($request->hasCookie('remember_web')) {
            cookie()->queue(cookie()->forget('remember_web'));
        }
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
