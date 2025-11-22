<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of all menu items across restaurants.
     */
    public function index(Request $request)
    {
        $query = MenuItem::with(['category.restaurant']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by restaurant
        if ($request->filled('restaurant_id')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('restaurant_id', $request->restaurant_id);
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by availability
        if ($request->filled('available')) {
            $query->where('is_available', $request->available === 'yes');
        }

        $menuItems = $query->latest()->paginate(20);
        
        // Get restaurants and categories for filters
        $restaurants = \App\Models\Restaurant::orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('admin.menu-items.index', compact('menuItems', 'restaurants', 'categories'));
    }
}
