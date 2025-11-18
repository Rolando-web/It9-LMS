<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\BookTransaction;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;


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

    public function staff()
    {
        // load pending borrow requests for admin approval
        $transactions = BookTransaction::with('book', 'user')
            ->where('status', 'pending')
            ->orderByDesc('borrowed_at')
            ->get();

        return view('Admin.staff', compact('transactions'));
    }

    public function home()
    {
        $books = \App\Models\Book::latest()->take(8)->get();

        // Get book counts by category (no facade alias issues)
        $categories = Book::query()
            ->select('category')
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('category')
            ->orderByDesc('count')
            ->pluck('count', 'category');

        return view('layouts.app', compact('books', 'categories'));
    }

    public function book()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $borrowed = BookTransaction::with('book')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'borrowed', 'overdue'])
            ->orderByDesc('borrowed_at')
            ->get();

        return view('pages.book-return', compact('borrowed'));
    }

    public function collection(Request $request)
    {
        $perPage = 8;
        $paginator = $this->buildBookQuery($request)->paginate($perPage)->appends($request->query());
        $books = $paginator;

        $user = Auth::user();
        $borrowedBookIds = [];
        if ($user) {
            $borrowedBookIds = BookTransaction::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'borrowed', 'overdue'])
                ->pluck('book_id')
                ->toArray();
        }

        return view('pages.book-collection', compact('books', 'borrowedBookIds'));
    }

    /**
     * AJAX endpoint: returns JSON of next page of books
     */
    public function loadMoreBooks(Request $request)
    {
        $perPage = (int) $request->query('per_page', 8);
        $page = (int) $request->query('page', 1);

        $paginator = $this->buildBookQuery($request)->paginate($perPage, ['*'], 'page', $page);

        // Get user's currently borrowed book IDs
        $user = Auth::user();
        $borrowedBookIds = [];
        if ($user) {
            $borrowedBookIds = BookTransaction::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'borrowed', 'overdue'])
                ->pluck('book_id')
                ->toArray();
        }

        // transform books to simple array for JSON
        $books = $paginator->items();

        $data = array_map(function ($b) use ($borrowedBookIds) {
            return [
                'id' => $b->id,
                'title' => $b->title,
                'category' => $b->category,
                'author' => $b->author,
                'publish_year' => optional($b->publish_date) ? \Carbon\Carbon::parse($b->publish_date)->format('Y') : null,
                'image' => $b->image ? asset($b->image) : asset('image/default-book.jpg'),
                'copies' => $b->copies ?? 0,
                'is_borrowed' => in_array($b->id, $borrowedBookIds),
            ];
        }, $books);

        return response()->json([
            'data' => $data,
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
        ]);
    }

    /**
     * Build a Book query applying search, category and sort parameters from the request.
     */
    protected function buildBookQuery(Request $request)
    {
        $q = Book::query();

        $search = $request->query('search', $request->input('search'));
        if ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $category = $request->query('category', $request->input('category'));
        if ($category && $category !== 'all') {
            // Case-insensitive category match
            $q->whereRaw('LOWER(category) = ?', [strtolower($category)]);
        }

        $sort = $request->query('sort', $request->input('sort'));
        if ($sort) {
            switch ($sort) {
                case 'title':
                    $q->orderBy('title');
                    break;
                case 'author':
                    $q->orderBy('author');
                    break;
                case 'year':
                    $q->orderBy('publish_date', 'desc');
                    break;
                default:
                    $q->latest();
            }
        } else {
            $q->latest();
        }

        return $q;
    }

    public function transaction()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $perPage = 10;

        // Active: currently not finalized transactions
        // - borrowed (not returned)
        // - overdue but not yet returned
        // - return_pending (awaiting staff action)
        $active = BookTransaction::with('book')
            ->where('user_id', $user->id)
            ->where(function ($q) {
                $q->whereIn('status', ['borrowed', 'return_pending'])
                    ->orWhere(function ($qq) {
                        $qq->where('status', 'overdue')
                            ->whereNull('returned_at');
                    });
            })
            ->orderByDesc('borrowed_at')
            ->paginate($perPage, ['*'], 'active_page');

        // History: finalized transactions (returned, damaged, and overdue that were returned)
        $history = BookTransaction::with('book')
            ->where('user_id', $user->id)
            ->whereIn('status', ['returned', 'damaged', 'overdue'])
            ->whereNotNull('returned_at')
            ->orderByDesc('borrowed_at')
            ->paginate($perPage, ['*'], 'history_page');

        $totalTransactions = BookTransaction::where('user_id', $user->id)->count();
        $overdueCount = BookTransaction::where('user_id', $user->id)->where('status', 'overdue')->count();

        // Outstanding fees: include stored fees (returned/damaged/return_pending)
        // Use fallback for 'returned' items where fee was not stored (compute from returned_at vs due_date)
        $storedFees = BookTransaction::where('user_id', $user->id)
            ->whereIn('status', ['returned', 'damaged', 'return_pending'])
            ->get(['status', 'fee', 'due_date', 'returned_at'])
            ->sum(function ($tx) {
                $fee = max(0, (float) ($tx->fee ?? 0));
                // Fallback only for returned rows when fee is zero
                if ($tx->status === 'returned' && $fee <= 0 && !empty($tx->due_date) && !empty($tx->returned_at)) {
                    $due = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
                    $ret = \Carbon\Carbon::parse($tx->returned_at)->startOfDay();
                    if ($ret->greaterThan($due)) {
                        return $due->diffInDays($ret) * 50;
                    }
                }
                return $fee;
            });

        // Include stored fees for overdue transactions that have been finalized (returned_at is set)
        // For safety, if some finalized overdue rows stored fee as 0, compute fallback from returned_at vs due_date
        $storedFinalizedOverdue = BookTransaction::where('user_id', $user->id)
            ->where('status', 'overdue')
            ->whereNotNull('returned_at')
            ->get(['fee', 'due_date', 'returned_at'])
            ->sum(function ($tx) {
                $fee = max(0, (float) ($tx->fee ?? 0));
                if ($fee > 0) return $fee;
                if (!empty($tx->due_date) && !empty($tx->returned_at)) {
                    $due = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
                    $ret = \Carbon\Carbon::parse($tx->returned_at)->startOfDay();
                    if ($ret->greaterThan($due)) {
                        return $due->diffInDays($ret) * 50;
                    }
                }
                return 0;
            });

        // Add LIVE overdue for unreturned items past due date (+50/day)
        $now = \Carbon\Carbon::now()->startOfDay();
        $liveOverdueFees = BookTransaction::where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->whereNull('returned_at')
            ->whereNotNull('due_date')
            ->get(['due_date'])
            ->sum(function ($tx) use ($now) {
                $due = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
                if ($now->greaterThan($due)) {
                    return $due->diffInDays($now) * 50;
                }
                return 0;
            });

        $outstandingFees = max(0, $storedFees + $storedFinalizedOverdue + $liveOverdueFees);

        // Total fee (historical + active frozen fees) for user summary
        // For completeness, keep totalUserFees aligned with outstanding today
        $totalUserFees = $outstandingFees;

        return view('pages.user-transaction', compact('active', 'history', 'totalTransactions', 'overdueCount', 'outstandingFees', 'totalUserFees'));
    }




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

    public function useradmin()
    {
        $users = User::orderByDesc('created_at')->paginate(5);
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $superAdmins = User::where('role', 'super_admin')->count();
        $activeUsers = $totalUsers;

        return view('Admin.useradmin', compact('users', 'totalUsers', 'admins', 'superAdmins', 'activeUsers'));
    }

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


    public function books(Request $request)
    {
        // Optional category filter
        $selectedCategory = $request->query('category');
        $search = $request->query('search');

        $q = Book::with('user');
        if ($selectedCategory && $selectedCategory !== 'all') {
            $q->where('category', $selectedCategory);
        }

        if (!empty($search)) {
            $term = trim($search);
            $q->where(function ($sub) use ($term) {
                if (ctype_digit($term)) {
                    $id = (int) $term;
                    $sub->where('id', $id)
                        ->orWhere('title', 'like', "%{$term}%");
                } else {
                    $sub->where('title', 'like', "%{$term}%");
                }
            });
        }

        $q->latest();

        // Paginate admin books list (5 per page) and preserve query params
        $books = $q->paginate(5)->appends($request->query());

        // Distinct list of categories for filter dropdown
        $categories = Book::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        if ($request->ajax()) {
            return view('Admin.partials.books-table', ['books' => $books]);
        }

        return view('Admin.books', [
            'books' => $books,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'search' => $search,
        ]);
    }
    public function transactions()
    {
        $transactions = BookTransaction::with(['user', 'book'])
            ->orderByDesc('created_at')
            ->paginate(10);

        // Calculate statistics
        $totalBorrowed = BookTransaction::whereIn('status', ['pending', 'borrowed', 'overdue'])->count();
        $totalReturned = BookTransaction::where('status', 'returned')->count();
        $totalOverdue = BookTransaction::where('status', 'overdue')->count();

        // Comprehensive fee aggregation matching row display logic.
        // Iterate all transactions (not just current page) and compute a display-equivalent fee.
        $allForFees = BookTransaction::select([
            'status',
            'fee',
            'due_date',
            'returned_at',
            'return_requested_at',
            'days_overdue'
        ])->get();

        $today = \Carbon\Carbon::now()->startOfDay();
        $totalFees = $allForFees->sum(function ($tx) use ($today) {
            $status = $tx->status;
            $stored = max(0, (float) ($tx->fee ?? 0));
            $dueDate = empty($tx->due_date) ? null : \Carbon\Carbon::parse($tx->due_date)->startOfDay();
            $retDate = empty($tx->returned_at) ? null : \Carbon\Carbon::parse($tx->returned_at)->startOfDay();
            $reqDate = empty($tx->return_requested_at) ? null : \Carbon\Carbon::parse($tx->return_requested_at)->startOfDay();

            // Borrowed or overdue but not yet returned: live overdue accrues.
            if (in_array($status, ['borrowed', 'overdue']) && is_null($retDate)) {
                if ($dueDate && $today->greaterThan($dueDate)) {
                    $days = $dueDate->diffInDays($today);
                    return max(0, $days * 50);
                }
                return 0;
            }

            // Return pending: use frozen stored fee if captured, else reconstruct then fallback to live.
            if ($status === 'return_pending') {
                if ($stored > 0) return $stored;
                if (!is_null($tx->days_overdue) && $tx->days_overdue > 0) {
                    return $tx->days_overdue * 50;
                } elseif ($reqDate && $dueDate && $reqDate->greaterThan($dueDate)) {
                    return $dueDate->diffInDays($reqDate) * 50;
                } elseif ($dueDate && $today->greaterThan($dueDate)) {
                    return $dueDate->diffInDays($today) * 50;
                }
                return 0;
            }

            // Finalized states: returned, overdue (with returned_at), damaged.
            if (in_array($status, ['returned', 'overdue', 'damaged']) && $retDate) {
                if ($stored > 0) return $stored; // includes damage fee already
                if ($dueDate && $retDate->greaterThan($dueDate)) {
                    return $dueDate->diffInDays($retDate) * 50;
                }
                return 0;
            }

            // Pending / rejected / others: fee zero.
            return $stored; // typically 0
        });

        return view('Admin.transaction', compact(
            'transactions',
            'totalBorrowed',
            'totalReturned',
            'totalOverdue',
            'totalFees'
        ));
    }

    public function categories()
    {
        return view('Admin.categories');
    }
}
