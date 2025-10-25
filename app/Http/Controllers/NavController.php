<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;

class NavController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function home()
    {
        return view('layouts.app');
    }

    public function book()
    {
        return view('pages.book-return');
    }

    public function collection()
    {
        return view('pages.book-collection');
    }

    public function transaction()
    {
        return view('pages.user-transaction');
    }




    public function activitylog()
    {
        return view('Admin.activitylog');
    }

    public function useradmin()
    {
        $users = User::orderByDesc('created_at')->paginate(5);
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $superAdmins = User::where('role', 'super_admin')->count();
        $activeUsers = $totalUsers; // No status column; treat all as active for now

        return view('Admin.useradmin', compact('users', 'totalUsers', 'admins', 'superAdmins', 'activeUsers'));
    }

    public function dashboard()
    {
        $books = Book::latest()->get();
        return view('Admin.dashboard', compact('books'));
    }


    public function books()
    {
        $books = Book::with('user')->latest()->get();
        return view('Admin.books', compact('books'));
    }
    public function transactions()
    {
        return view('Admin.transaction');
    }

    public function categories()
    {
        return view('Admin.categories');
    }
}
