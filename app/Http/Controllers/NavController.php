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
        $books = \App\Models\Book::latest()->take(8)->get();
        return view('layouts.app', compact('books'));
    }

    public function book()
    {
        return view('pages.book-return');
    }

    public function collection(Request $request)
    {
        $perPage = 8;
        $paginator = $this->buildBookQuery($request)->paginate($perPage)->appends($request->query());
        $books = $paginator;
        return view('pages.book-collection', compact('books'));
    }

    /**
     * AJAX endpoint: returns JSON of next page of books
     */
    public function loadMoreBooks(Request $request)
    {
        $perPage = (int) $request->query('per_page', 8);
        $page = (int) $request->query('page', 1);

        $paginator = $this->buildBookQuery($request)->paginate($perPage, ['*'], 'page', $page);

        // transform books to simple array for JSON
        $books = $paginator->items();

        $data = array_map(function ($b) {
            return [
                'id' => $b->id,
                'title' => $b->title,
                'author' => $b->author,
                'publish_year' => optional($b->publish_date) ? \Carbon\Carbon::parse($b->publish_date)->format('Y') : null,
                'image' => $b->image ? asset($b->image) : asset('image/default-book.jpg'),
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
