<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function saveBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'isbn' => 'required|string|max:50|unique:books,isbn',
            'publish_date' => 'required|date',
            'copies' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/books'), $imageName);
            $imagePath = 'storage/books/' . $imageName;
        }

        // Create the book
        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'category' => $validated['category'],
            'isbn' => $validated['isbn'],
            'publish_date' => $validated['publish_date'],
            'copies' => $validated['copies'],
            'image' => $imagePath,
            'user_id' => Auth::id(), // Save the logged-in user's ID
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user() ? Auth::user()->firstName . ' ' . Auth::user()->lastName : null,
            'role' => Auth::user() ? Auth::user()->role : null,
            'action' => 'Add Book',
            'details' => 'Added new book: ' . $validated['title'],
            'status' => 'success',
        ]);

        return redirect()->route('books')->with('success', 'Book added successfully!');
    }

    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function updateBook(Request $request)
    {
        $book = Book::findOrFail($request->edit_id);

        $validated = $request->validate([
            'edit_title' => 'required|string|max:255',
            'edit_author' => 'required|string|max:255',
            'edit_category' => 'required|string|max:100',
            'edit_isbn' => 'required|string|max:50|unique:books,isbn,' . $book->id,
            'edit_publish_date' => 'required|date',
            'edit_copies' => 'required|integer|min:1',
            'edit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $book->image;
        if ($request->hasFile('edit_image')) {
            if ($book->image && file_exists(public_path($book->image))) {
                unlink(public_path($book->image));
            }

            $image = $request->file('edit_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/books'), $imageName);
            $imagePath = 'storage/books/' . $imageName;
        }

        $book->update([
            'title' => $validated['edit_title'],
            'author' => $validated['edit_author'],
            'category' => $validated['edit_category'],
            'isbn' => $validated['edit_isbn'],
            'publish_date' => $validated['edit_publish_date'],
            'copies' => $validated['edit_copies'],
            'image' => $imagePath,
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user() ? Auth::user()->firstName . ' ' . Auth::user()->lastName : null,
            'role' => Auth::user() ? Auth::user()->role : null,
            'action' => 'Update Book',
            'details' => 'Updated book: ' . $book->title,
            'status' => 'success',
        ]);

        return redirect()->route('books')->with('success', 'Book updated successfully!');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        // Check if book is currently borrowed
        $isBorrowed = \App\Models\BookTransaction::where('book_id', $id)
            ->whereIn('status', ['borrowed', 'overdue', 'pending', 'return_pending'])
            ->exists();

        if ($isBorrowed) {
            return redirect()->route('books')->with('error', 'Cannot delete this book. It is currently borrowed by a user.');
        }

        if ($book->image && file_exists(public_path($book->image))) {
            unlink(public_path($book->image));
        }

        $book->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user() ? Auth::user()->firstName . ' ' . Auth::user()->lastName : null,
            'role' => Auth::user() ? Auth::user()->role : null,
            'action' => 'Delete Book',
            'details' => 'Deleted book: ' . $book->title,
            'status' => 'success',
        ]);

        return redirect()->route('books')->with('success', 'Book deleted successfully!');
    }

    // User book collection view
    public function collection(Request $request)
    {
        $perPage = 8;
        $paginator = $this->buildBookQuery($request)->paginate($perPage)->appends($request->query());
        $books = $paginator;

        $user = Auth::user();
        $borrowedBookIds = [];
        if ($user) {
            $borrowedBookIds = \App\Models\BookTransaction::where('user_id', $user->id)
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
            $borrowedBookIds = \App\Models\BookTransaction::where('user_id', $user->id)
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

    // Admin books management view
    public function adminBooks(Request $request)
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

        // Get categories from CategoryController
        $categoryController = new \App\Http\Controllers\CategoryController();
        $categories = $categoryController->getCategoriesForFilter();

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
}
