<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'customers' => User::where('role', 'customer')->count(),
            'restaurant_owners' => User::where('role', 'restaurant_owner')->count(),
            'drivers' => User::where('role', 'driver')->count(),
            'admins' => User::where('role', 'admin')->count(),
            
            'total_restaurants' => Restaurant::count(),
            'active_restaurants' => Restaurant::where('is_active', true)->count(),
            'inactive_restaurants' => Restaurant::where('is_active', false)->count(),
            
            'total_categories' => Category::count(),
            'total_menu_items' => MenuItem::count(),
            'available_menu_items' => MenuItem::where('is_available', true)->count(),
            
            // Placeholders for future order system
            'total_orders' => 0,
            'total_revenue' => 0,
            'pending_orders' => 0,
        ];

        // Recent restaurants
        $recentRestaurants = Restaurant::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent users
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRestaurants', 'recentUsers'));
    }
}
