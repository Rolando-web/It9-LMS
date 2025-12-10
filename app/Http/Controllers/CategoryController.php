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
        // Get book counts per category from the database
        $categoryCounts = Book::query()
            ->select('category')
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Define the predefined categories with their styling
        $predefinedCategories = [
            'Arts' => ['name' => 'Arts & Culture', 'icon' => 'bi-palette-fill', 'color' => 'purple', 'image' => 'arts.jpg'],
            'Biology' => ['name' => 'Biology', 'icon' => 'bi-flower1', 'color' => 'green', 'image' => 'biology.jpg'],
            'Business' => ['name' => 'Business', 'icon' => 'bi-briefcase-fill', 'color' => 'blue', 'image' => 'business.jpg'],
            'Fiction' => ['name' => 'Fiction', 'icon' => 'bi-stars', 'color' => 'pink', 'image' => 'fiction.jpg'],
            'History' => ['name' => 'History', 'icon' => 'bi-clock-history', 'color' => 'amber', 'image' => 'history.jpg'],
            'Technology' => ['name' => 'Technology', 'icon' => 'bi-cpu-fill', 'color' => 'cyan', 'image' => 'technology.jpg'],
            'Philosophy' => ['name' => 'Philosophy', 'icon' => 'bi-lightbulb-fill', 'color' => 'indigo', 'image' => 'philosophy.jpg'],
            'Science' => ['name' => 'Science', 'icon' => 'bi-rocket-takeoff-fill', 'color' => 'emerald', 'image' => 'science.jpg'],
        ];

        // Build categories array with counts
        $categories = [];
        foreach ($predefinedCategories as $key => $config) {
            $categories[] = [
                'key' => $key,
                'name' => $config['name'],
                'icon' => $config['icon'],
                'color' => $config['color'],
                'image' => $config['image'],
                'count' => $categoryCounts[$key] ?? 0,
            ];
        }

        $totalCategories = count($predefinedCategories);

        return view('Admin.categories', compact('categories', 'totalCategories'));
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
