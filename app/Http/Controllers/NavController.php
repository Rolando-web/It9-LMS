<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\BookTransaction;
use App\Models\Notification;

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
        return view('layouts.app', compact('books'));
    }

    public function book()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // include pending transactions so user can see requests awaiting approval
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

        // Get user's currently borrowed book IDs (pending, borrowed, or overdue status)
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
            $q->where('category', $category);
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

        $active = BookTransaction::with('book')
            ->where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->orderByDesc('borrowed_at')
            ->paginate($perPage, ['*'], 'active_page');

        $history = BookTransaction::with('book')
            ->where('user_id', $user->id)
            ->where('status', 'returned')
            ->orderByDesc('borrowed_at')
            ->paginate($perPage, ['*'], 'history_page');

        $totalTransactions = BookTransaction::where('user_id', $user->id)->count();
        $overdueCount = BookTransaction::where('user_id', $user->id)->where('status', 'overdue')->count();

        // Calculate outstanding fees: sum of all fees from returned books + current overdue books
        $outstandingFees = BookTransaction::where('user_id', $user->id)
            ->whereIn('status', ['returned', 'overdue'])
            ->sum('fee');

        return view('pages.user-transaction', compact('active', 'history', 'totalTransactions', 'overdueCount', 'outstandingFees'));
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
        // Get all transactions with user and book relationships (paginated to 7 per page)
        $transactions = BookTransaction::with(['user', 'book'])
            ->orderByDesc('created_at')
            ->paginate(7);

        // Calculate statistics
        $totalBorrowed = BookTransaction::whereIn('status', ['pending', 'borrowed', 'overdue'])->count();
        $totalReturned = BookTransaction::where('status', 'returned')->count();
        $totalOverdue = BookTransaction::where('status', 'overdue')->count();
        $totalFees = BookTransaction::sum('fee');

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

    // Get user's notifications
    public function getNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $notifications = Notification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    // Mark notification as read
    public function markNotificationAsRead($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $notification->is_read = true;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }
}
