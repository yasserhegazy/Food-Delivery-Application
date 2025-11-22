<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories across restaurants.
     */
    public function index(Request $request)
    {
        $query = Category::with('restaurant');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by restaurant
        if ($request->filled('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        $categories = $query->latest()->paginate(20);
        
        // Get restaurants for filter
        $restaurants = \App\Models\Restaurant::orderBy('name')->get();

        return view('admin.categories.index', compact('categories', 'restaurants'));
    }
}
