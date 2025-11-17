<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password; // kept but not used in simplified flow
use Illuminate\Validation\ValidationException; // kept for potential future use
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth as AuthFacade;

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

    /**
     * Show the register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Home page view
     */
    public function home()
    {
        $books = \App\Models\Book::latest()->take(8)->get();

        // Get category statistics from CategoryController
        $categoryController = new \App\Http\Controllers\CategoryController();
        $categories = $categoryController->getCategoryStats();

        // Get statistics for hero section
        $totalBooks = \App\Models\Book::sum('copies'); // Total available copies
        $activeMembers = \App\Models\User::where('role', 'user')->count();
        $totalAdmins = \App\Models\User::whereIn('role', ['admin', 'super_admin'])->count();

        return view('layouts.app', compact('books', 'categories', 'totalBooks', 'activeMembers', 'totalAdmins'));
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

        // Log registration
        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->firstName . ' ' . $user->lastName,
            'role' => $user->role ?? 'user',
            'action' => 'Register',
            'details' => 'Created new account',
            'status' => 'success',
        ]);

        // Automatically log in the user after registration
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect to user dashboard (home)
        return redirect()->route('home')->with('success', 'Account Created Successfully! Welcome to the Library Management System.');
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

            // Log login
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->firstName . ' ' . $user->lastName,
                'role' => $user->role,
                'action' => 'Login',
                'details' => 'User logged in',
                'status' => 'success',
            ]);

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

        $user = Auth::user();

        // Log logout
        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->firstName . ' ' . $user->lastName,
                'role' => $user->role,
                'action' => 'Logout',
                'details' => 'User logged out',
                'status' => 'success',
            ]);
        }

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
