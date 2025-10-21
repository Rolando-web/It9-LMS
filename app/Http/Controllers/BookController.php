<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveBook(Request $request)
    {
        // Validate the request
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
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
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
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
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

        return redirect()->route('books')->with('success', 'Book updated successfully!');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->image && file_exists(public_path($book->image))) {
            unlink(public_path($book->image));
        }

        $book->delete();

        return redirect()->route('books')->with('success', 'Book deleted successfully!');
    }
}
