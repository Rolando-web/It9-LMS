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

    // Update an existing user (super_admin only via route middleware)
    public function update(Request $request, $id)
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin,super_admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->firstName = $validated['firstName'];
        $user->lastName = $validated['lastName'];
        $user->email = $validated['email'];
        $user->contact = $validated['contact'] ?? null;
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        ActivityLog::create([
            'user_id' => $currentUser->id,
            'user_name' => $currentUser->firstName . ' ' . $currentUser->lastName,
            'role' => $currentUser->role,
            'action' => 'Update User',
            'details' => 'Updated user: ' . $user->firstName . ' ' . $user->lastName . ' (' . $user->role . ')',
            'status' => 'success',
        ]);

        return redirect()->route('user-admin')->with('success', 'User updated successfully!');
    }

    // Delete a user (super_admin only via route middleware)
    public function destroy($id)
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        // Optional: prevent deleting own account
        if ($user->id === $currentUser->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->firstName . ' ' . $user->lastName;
        $role = $user->role;
        $user->delete();

        ActivityLog::create([
            'user_id' => $currentUser->id,
            'user_name' => $currentUser->firstName . ' ' . $currentUser->lastName,
            'role' => $currentUser->role,
            'action' => 'Delete User',
            'details' => 'Deleted user: ' . $name . ' (' . $role . ')',
            'status' => 'success',
        ]);

        return redirect()->route('user-admin')->with('success', 'User deleted successfully!');
    }
}
