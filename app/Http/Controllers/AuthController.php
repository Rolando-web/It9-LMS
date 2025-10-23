<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
