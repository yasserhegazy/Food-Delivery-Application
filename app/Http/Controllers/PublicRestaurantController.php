<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class PublicRestaurantController extends Controller
{
    /**
     * Display a listing of restaurants.
     */
    public function index(Request $request)
    {
        $query = Restaurant::query()->active()->with('categories');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->byCity($request->city);
        }

        // Filter by rating
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        // Sort
        $sortBy = $request->get('sort', 'rating');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $restaurants = $query->paginate(12);
        $cities = Restaurant::distinct()->pluck('city');

        return view('restaurants.index', compact('restaurants', 'cities'));
    }

    /**
     * Display the specified restaurant menu.
     */
    public function show($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->with(['categories.menuItems' => function ($query) {
                $query->available()->ordered();
            }])
            ->firstOrFail();

        return view('restaurants.show', compact('restaurant'));
    }
}
