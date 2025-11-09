<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ActivityLog;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('layouts.app', compact('user'));
    }

    // Admin adds a new user
    public function store(Request $request)
    {
        // Check if user is admin or super_admin
        $currentUser = Auth::user();
        if (!$currentUser || !in_array($currentUser->role, ['admin', 'super_admin'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin,super_admin',
        ]);

        $user = User::create([
            'firstName' => $validated['firstName'],
            'lastName' => $validated['lastName'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Log the activity
        ActivityLog::create([
            'user_id' => $currentUser->id,
            'user_name' => $currentUser->firstName . ' ' . $currentUser->lastName,
            'role' => $currentUser->role,
            'action' => 'Add User',
            'details' => 'Added new user: ' . $user->firstName . ' ' . $user->lastName . ' (' . $validated['role'] . ')',
            'status' => 'success',
        ]);

        return redirect()->route('user-admin')->with('success', 'User added successfully!');
    }
}
