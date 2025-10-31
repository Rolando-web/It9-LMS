<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function createAdminUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:user,admin,super_admin',
        ]);

        User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Log admin creation
        ActivityLog::create([
            'user_id' => null,
            'user_name' => $request->firstName . ' ' . $request->lastName,
            'role' => $request->role,
            'action' => 'Create User',
            'details' => 'Admin created user: ' . $request->email,
            'status' => 'success',
        ]);

        return redirect('login')->back()->with('success', 'User created successfully!');
    }
}
