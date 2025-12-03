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
        // Cache stats for 5 minutes to reduce DB load
        $totalBooks = \Cache::remember('dashboard.total_books', 300, fn() => Book::count());
        $categoriesCount = \Cache::remember('dashboard.categories', 300, fn() => Book::distinct('category')->count('category'));
        $availableCopies = \Cache::remember('dashboard.copies', 300, fn() => Book::sum('copies'));
        $authorsCount = \Cache::remember('dashboard.authors', 300, fn() => Book::distinct('author')->count('author'));

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

    // Generate PDF report for date range
    public function downloadReport(Request $request)
    {
        $startDateStr = $request->query('start_date');
        $endDateStr = $request->query('end_date');
        
        try {
            $start = $startDateStr ? \Carbon\Carbon::parse($startDateStr)->startOfDay() : now()->startOfDay();
            $end = $endDateStr ? \Carbon\Carbon::parse($endDateStr)->endOfDay() : now()->endOfDay();
        } catch (\Exception $e) {
            $start = now()->startOfDay();
            $end = now()->endOfDay();
        }
        
        // Ensure start is not after end
        if ($start->greaterThan($end)) {
            $temp = $start;
            $start = $end;
            $end = $temp;
        }

        // Gather statistics
        $booksAdded = Book::whereBetween('created_at', [$start, $end])->count();
        $totalBorrowed = BookTransaction::whereBetween('borrowed_at', [$start, $end])->count();
        $totalReturned = BookTransaction::whereBetween('returned_at', [$start, $end])
            ->whereIn('status', ['returned', 'damaged', 'overdue'])
            ->whereNotNull('returned_at')
            ->count();
        $returnedWell = BookTransaction::where('status', 'returned')
            ->whereBetween('returned_at', [$start, $end])
            ->count();
        $returnedDamaged = BookTransaction::where('status', 'damaged')
            ->whereBetween('returned_at', [$start, $end])
            ->count();
        $totalActivities = ActivityLog::whereBetween('created_at', [$start, $end])->count();
        $totalFees = BookTransaction::whereBetween('returned_at', [$start, $end])
            ->whereNotNull('returned_at')
            ->sum('fee');

        // Get detailed data
        $recentBooks = Book::whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        $transactions = BookTransaction::with(['user', 'book'])
            ->whereBetween('borrowed_at', [$start, $end])
            ->orderByDesc('borrowed_at')
            ->get();

        $activities = ActivityLog::whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'booksAdded' => $booksAdded,
            'totalBorrowed' => $totalBorrowed,
            'totalReturned' => $totalReturned,
            'returnedWell' => $returnedWell,
            'returnedDamaged' => $returnedDamaged,
            'totalActivities' => $totalActivities,
            'totalFees' => $totalFees,
            'dayCount' => $start->diffInDays($end) + 1,
        ];

        $startDate = $start->format('M d, Y');
        $endDate = $end->format('M d, Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.dashboard-report', compact(
            'startDate',
            'endDate',
            'stats',
            'recentBooks',
            'transactions',
            'activities'
        ));

        $filename = 'dashboard-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

    // AJAX: Dashboard data for a date range
    public function dashboardByDate(Request $request)
    {
        $startDateStr = $request->query('start_date');
        $endDateStr = $request->query('end_date');
        
        try {
            $start = $startDateStr ? \Carbon\Carbon::parse($startDateStr)->startOfDay() : now()->startOfDay();
            $end = $endDateStr ? \Carbon\Carbon::parse($endDateStr)->endOfDay() : now()->endOfDay();
        } catch (\Exception $e) {
            $start = now()->startOfDay();
            $end = now()->endOfDay();
        }
        
        // Ensure start is not after end
        if ($start->greaterThan($end)) {
            $temp = $start;
            $start = $end;
            $end = $temp;
        }

        // Return status (for the selected day)
        $returnedWell = BookTransaction::where('status', 'returned')
            ->whereBetween('returned_at', [$start, $end])
            ->count();
        $returnedDamaged = BookTransaction::where('status', 'damaged')
            ->whereBetween('returned_at', [$start, $end])
            ->count();

        // Calculate total days in range
        $totalDays = $start->diffInDays($end) + 1;
        
        // For single day: show hourly breakdown (0-23)
        // For multiple days: show daily breakdown
        if ($totalDays == 1) {
            // Borrowed by hour (0-23) for single day
            $borrowedByHour = [];
            for ($h = 0; $h < 24; $h++) {
                $hStart = $start->copy()->addHours($h);
                $hEnd = $hStart->copy()->endOfHour();
                $count = BookTransaction::whereBetween('borrowed_at', [$hStart, $hEnd])->count();
                $borrowedByHour[] = [
                    'hour' => $hStart->format('H:00'),
                    'count' => $count,
                ];
            }

            // Activities by hour (0-23) for single day
            $activitiesByHour = [];
            for ($h = 0; $h < 24; $h++) {
                $hStart = $start->copy()->addHours($h);
                $hEnd = $hStart->copy()->endOfHour();
                $count = ActivityLog::whereBetween('created_at', [$hStart, $hEnd])->count();
                $activitiesByHour[] = [
                    'hour' => $hStart->format('H:00'),
                    'count' => $count,
                ];
            }
        } else {
            // Borrowed by day for date range
            $borrowedByHour = [];
            $currentDate = $start->copy();
            while ($currentDate->lte($end)) {
                $dayStart = $currentDate->copy()->startOfDay();
                $dayEnd = $currentDate->copy()->endOfDay();
                $count = BookTransaction::whereBetween('borrowed_at', [$dayStart, $dayEnd])->count();
                $borrowedByHour[] = [
                    'hour' => $currentDate->format('M d'),
                    'count' => $count,
                ];
                $currentDate->addDay();
            }

            // Activities by day for date range
            $activitiesByHour = [];
            $currentDate = $start->copy();
            while ($currentDate->lte($end)) {
                $dayStart = $currentDate->copy()->startOfDay();
                $dayEnd = $currentDate->copy()->endOfDay();
                $count = ActivityLog::whereBetween('created_at', [$dayStart, $dayEnd])->count();
                $activitiesByHour[] = [
                    'hour' => $currentDate->format('M d'),
                    'count' => $count,
                ];
                $currentDate->addDay();
            }
        }

        // Recently added books on selected day (limit 5)
        $recentBooks = Book::whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Card metrics for selected day
        $booksAddedCount = Book::whereBetween('created_at', [$start, $end])->count();
        $categoriesCountDay = Book::whereBetween('created_at', [$start, $end])
            ->distinct('category')->count('category');
        $availableCopiesDay = Book::whereBetween('created_at', [$start, $end])->sum('copies');
        $authorsCountDay = Book::whereBetween('created_at', [$start, $end])
            ->distinct('author')->count('author');

        // Render rows partial
        $rowsHtml = view('Admin.partials.dashboard-recent-rows', [
            'recentBooks' => $recentBooks,
        ])->render();

        return response()->json([
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'returnedWell' => $returnedWell,
            'returnedDamaged' => $returnedDamaged,
            'borrowedByHour' => $borrowedByHour,
            'activitiesByHour' => $activitiesByHour,
            'recentRowsHtml' => $rowsHtml,
            'totalBooksDay' => $booksAddedCount,
            'categoriesCountDay' => $categoriesCountDay,
            'availableCopiesDay' => $availableCopiesDay,
            'authorsCountDay' => $authorsCountDay,
        ]);
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
