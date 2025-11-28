<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Services\SearchService;
use Illuminate\Http\Request;

class PublicRestaurantController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Display a listing of restaurants.
     */
    public function index(Request $request)
    {
        $query = $this->searchService->searchRestaurants($request->all());
        
        $restaurants = $query->paginate(12)->withQueryString();
        
        // Get filter options
        $filterOptions = $this->searchService->getFilterOptions();
        
        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'restaurants' => $restaurants,
                'filters' => $filterOptions,
            ]);
        }

        return view('restaurants.index', [
            'restaurants' => $restaurants,
            'cities' => $filterOptions['cities'],
            'cuisines' => $filterOptions['cuisines'],
            'filterOptions' => $filterOptions,
        ]);
    }

    /**
     * AJAX search endpoint for live search
     */
    public function search(Request $request)
    {
        $query = $this->searchService->searchRestaurants($request->all());
        
        $restaurants = $query->paginate(12)->withQueryString();
        
        return response()->json([
            'success' => true,
            'data' => $restaurants,
            'total' => $restaurants->total(),
        ]);
    }

    /**
     * Get autocomplete suggestions
     */
    public function suggestions(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'suggestions' => [],
            ]);
        }

        $suggestions = $this->searchService->getSearchSuggestions($query);
        
        // Record search for analytics
        if (auth()->check()) {
            $this->searchService->recordSearch($query, auth()->id());
        }

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions,
            'popular' => $this->searchService->getPopularSearches(),
        ]);
    }

    /**
     * Get available filter options
     */
    public function filters()
    {
        $filterOptions = $this->searchService->getFilterOptions();
        
        return response()->json([
            'success' => true,
            'filters' => $filterOptions,
        ]);
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
