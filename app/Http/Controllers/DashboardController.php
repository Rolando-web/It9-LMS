<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\BookTransaction;

class DashboardController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        // Stats across all books
        $totalBooks = Book::count();
        $categoriesCount = Book::distinct('category')->count('category');
        $availableCopies = Book::sum('copies');
        $authorsCount = Book::distinct('author')->count('author');

        // Recently added books, paginated (5 per page)
        $recentBooks = Book::latest()->paginate(5);

        return view('Admin.dashboard', compact(
            'recentBooks',
            'totalBooks',
            'categoriesCount',
            'availableCopies',
            'authorsCount'
        ));
    }

    // Staff management view
    public function staff()
    {
        // load pending borrow requests for admin approval
        $transactions = BookTransaction::with('book', 'user')
            ->where('status', 'pending')
            ->orderByDesc('borrowed_at')
            ->get();

        return view('Admin.staff', compact('transactions'));
    }

    // Activity log view
    public function activitylog()
    {
        $perPage = 15;
        $activities = ActivityLog::with('user')->latest()->paginate($perPage);

        $totalActivities = ActivityLog::count();
        $userLogins = ActivityLog::where('action', 'Login')->count();
        $bookActions = ActivityLog::where('action', 'like', '%Book%')->count();
        $todaysActivity = ActivityLog::whereDate('created_at', now()->toDateString())->count();

        return view('Admin.activitylog', compact('activities', 'totalActivities', 'userLogins', 'bookActions', 'todaysActivity'));
    }

    // User admin view
    public function useradmin()
    {
        $users = User::orderByDesc('created_at')->paginate(5);
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $superAdmins = User::where('role', 'super_admin')->count();
        $activeUsers = $totalUsers;

        return view('Admin.useradmin', compact('users', 'totalUsers', 'admins', 'superAdmins', 'activeUsers'));
    }
}
