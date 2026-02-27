<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

        // Get recently viewed restaurants from session
        $recentlyViewedIds = $request->session()->get('recently_viewed_restaurants', []);
        $recentlyViewed = collect();
        if (!empty($recentlyViewedIds)) {
            $recentlyViewed = Restaurant::whereIn('id', $recentlyViewedIds)
                ->where('is_active', true)
                ->with('categories')
                ->get()
                ->sortBy(function ($restaurant) use ($recentlyViewedIds) {
                    return array_search($restaurant->id, $recentlyViewedIds);
                })
                ->values();
        }

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
            'recentlyViewed' => $recentlyViewed,
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

        $cuisines = Cache::remember('available_cuisines', 3600, function () {
            return Restaurant::getAvailableCuisines();
        });

        $filterOptions['cuisines'] = $cuisines;

        return response()->json([
            'success' => true,
            'filters' => $filterOptions,
        ]);
    }

    /**
     * Display the specified restaurant menu.
     */
    public function show(Request $request, $slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->with(['categories' => function ($query) {
                $query->orderBy('sort_order');
            }, 'categories.menuItems'])
            ->firstOrFail();

        // Track recently viewed restaurants in session
        $recentlyViewed = $request->session()->get('recently_viewed_restaurants', []);
        // Remove if already exists to avoid duplicates
        $recentlyViewed = array_values(array_diff($recentlyViewed, [$restaurant->id]));
        // Prepend to front (most recent first)
        array_unshift($recentlyViewed, $restaurant->id);
        // Keep only last 4
        $recentlyViewed = array_slice($recentlyViewed, 0, 4);
        $request->session()->put('recently_viewed_restaurants', $recentlyViewed);

        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Get menu items for a specific category
     */
    public function categoryItems(Restaurant $restaurant, $categoryId)
    {
        $category = $restaurant->categories()->findOrFail($categoryId);
        
        $items = $category->menuItems()
            ->available()
            ->ordered()
            ->paginate(12);

        $html = '';
        foreach ($items as $item) {
            $html .= view('components.menu-item-card', ['item' => $item])->render();
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'hasMore' => $items->hasMorePages(),
            'nextPageUrl' => $items->nextPageUrl(),
            'total' => $items->total()
        ]);
    }
}
