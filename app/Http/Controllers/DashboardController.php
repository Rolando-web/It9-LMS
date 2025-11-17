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

        // Chart data: Return Status Comparison (Returned vs Damaged)
        $returnedWell = BookTransaction::where('status', 'returned')->count();
        $returnedDamaged = BookTransaction::where('status', 'damaged')->count();

        // Chart data: Total Borrowed by Month (last 6 months)
        $borrowedByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $borrowedByMonth[] = [
                'month' => $date->format('M'),
                'count' => BookTransaction::whereMonth('borrowed_at', $date->month)
                    ->whereYear('borrowed_at', $date->year)
                    ->count()
            ];
        }

        // Chart data: Total Activities by Month (last 6 months)
        $activitiesByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $activitiesByMonth[] = [
                'month' => $date->format('M'),
                'count' => ActivityLog::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count()
            ];
        }

        return view('Admin.dashboard', compact(
            'recentBooks',
            'totalBooks',
            'categoriesCount',
            'availableCopies',
            'authorsCount',
            'returnedWell',
            'returnedDamaged',
            'borrowedByMonth',
            'activitiesByMonth'
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
