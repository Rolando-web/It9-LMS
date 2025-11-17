<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class CategoryController extends Controller
{
    /**
     * Show the categories management page
     */
    public function index()
    {
        return view('Admin.categories');
    }

    /**
     * Get all distinct categories with book counts
     */
    public function getAllCategories()
    {
        $categories = Book::query()
            ->select('category')
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('category')
            ->orderByDesc('count')
            ->get();

        return response()->json($categories);
    }

    /**
     * Get categories for dropdown/filter (distinct list)
     */
    public function getCategoriesForFilter()
    {
        $categories = Book::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return $categories;
    }

    /**
     * Get category statistics for home page
     */
    public function getCategoryStats()
    {
        $categories = Book::query()
            ->select('category')
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('category')
            ->orderByDesc('count')
            ->pluck('count', 'category');

        return $categories;
    }
}
