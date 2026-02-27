<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRestaurants = Cache::remember('home_featured_restaurants', 600, function () {
            return Restaurant::active()
                ->featured()
                ->with('categories')
                ->take(6)
                ->get();
        });

        $popularItems = MenuItem::with(['category.restaurant'])
            ->available()
            ->featured()
            ->take(8)
            ->get();

        $totalRestaurants = Restaurant::active()->count();
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'customer')->count();

        return view('welcome', compact(
            'featuredRestaurants',
            'popularItems',
            'totalRestaurants',
            'totalOrders',
            'totalUsers',
        ));
    }
}
