<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of restaurants (VIEW-ONLY).
     */
    public function index(Request $request)
    {
        $query = Restaurant::with('user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by rating
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        $restaurants = $query->latest()->paginate(12);
        
        // Get unique cities for filter
        $cities = Restaurant::distinct()->pluck('city')->sort();

        // Statistics
        $stats = [
            'total' => Restaurant::count(),
            'active' => Restaurant::where('is_active', true)->count(),
            'inactive' => Restaurant::where('is_active', false)->count(),
            'avg_rating' => Restaurant::avg('rating'),
        ];

        return view('admin.restaurants.index', compact('restaurants', 'cities', 'stats'));
    }

    /**
     * Display the specified restaurant with analytics (VIEW-ONLY).
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['user', 'categories.menuItems']);
        
        // Calculate statistics
        $stats = [
            'total_categories' => $restaurant->categories()->count(),
            'total_menu_items' => $restaurant->menuItems()->count(),
            'active_menu_items' => $restaurant->menuItems()->where('is_available', true)->count(),
            'avg_menu_price' => $restaurant->menuItems()->avg('price'),
            // Placeholders for future order system
            'total_orders' => 0,
            'total_revenue' => 0,
            'pending_orders' => 0,
        ];

        return view('admin.restaurants.show', compact('restaurant', 'stats'));
    }
}
