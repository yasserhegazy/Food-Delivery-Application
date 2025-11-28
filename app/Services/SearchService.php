<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchService
{
    /**
     * Search restaurants with advanced filters
     */
    public function searchRestaurants(array $filters)
    {
        $query = Restaurant::query()->active()->with('categories');

        // Text search
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Cuisine filter
        if (!empty($filters['cuisine'])) {
            $query->byCuisine($filters['cuisine']);
        }

        // City filter
        if (!empty($filters['city'])) {
            $query->byCity($filters['city']);
        }

        // Rating filter
        if (!empty($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        }

        // Price range filter
        if (!empty($filters['price_range'])) {
            $query->byPriceRange($filters['price_range']);
        }

        // Delivery fee filter
        if (!empty($filters['delivery_fee'])) {
            $query->byDeliveryFee($filters['delivery_fee']);
        }

        // Delivery time filter
        if (!empty($filters['delivery_time'])) {
            $query->byDeliveryTime($filters['delivery_time']);
        }

        // Open now filter
        if (!empty($filters['open_now'])) {
            $query->openNow();
        }

        // Sorting
        $sortBy = $filters['sort'] ?? 'rating';
        $sortOrder = $filters['order'] ?? 'desc';
        
        $allowedSorts = ['rating', 'delivery_time', 'delivery_fee', 'name'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query;
    }

    /**
     * Search menu items across all restaurants
     */
    public function searchMenuItems(array $filters)
    {
        $query = MenuItem::query()
            ->available()
            ->with(['category.restaurant']);

        // Text search
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Price range filter
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Category filter
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Restaurant filter
        if (!empty($filters['restaurant_id'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('restaurant_id', $filters['restaurant_id']);
            });
        }

        // Sorting
        $sortBy = $filters['sort'] ?? 'name';
        $sortOrder = $filters['order'] ?? 'asc';
        
        $allowedSorts = ['name', 'price', 'sort_order'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query;
    }

    /**
     * Get search suggestions for autocomplete
     */
    public function getSearchSuggestions(string $query, int $limit = 10)
    {
        $cacheKey = 'search_suggestions_' . md5($query);
        
        return Cache::remember($cacheKey, 300, function () use ($query, $limit) {
            $restaurants = Restaurant::active()
                ->search($query)
                ->select('id', 'name', 'slug', 'cuisine_type', 'logo', 'rating')
                ->limit($limit)
                ->get();

            $menuItems = MenuItem::available()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%');
                })
                ->with('category.restaurant:id,name,slug')
                ->select('id', 'category_id', 'name', 'price', 'image')
                ->limit($limit)
                ->get();

            return [
                'restaurants' => $restaurants,
                'menu_items' => $menuItems,
            ];
        });
    }

    /**
     * Get available filter options
     */
    public function getFilterOptions()
    {
        $cacheKey = 'filter_options';
        
        return Cache::remember($cacheKey, 3600, function () {
            return [
                'cuisines' => Restaurant::getAvailableCuisines(),
                'cities' => Restaurant::distinct()->pluck('city')->filter()->values(),
                'price_ranges' => ['$', '$$', '$$$', '$$$$'],
                'ratings' => [4.5, 4.0, 3.5, 3.0],
                'delivery_fees' => [
                    'free' => 'Free Delivery',
                    '5' => 'Under $5',
                    '10' => 'Under $10',
                ],
                'delivery_times' => [15, 30, 45, 60],
            ];
        });
    }

    /**
     * Get popular searches (placeholder for future analytics)
     */
    public function getPopularSearches(int $limit = 5)
    {
        // This would typically come from a search_logs table
        // For now, return some default popular searches
        return [
            'Pizza',
            'Burger',
            'Sushi',
            'Chinese',
            'Italian',
        ];
    }

    /**
     * Record search for analytics (placeholder)
     */
    public function recordSearch(string $query, ?int $userId = null)
    {
        // Future implementation: store in search_logs table
        // For now, we'll just log it
        Log::info('Search query', [
            'query' => $query,
            'user_id' => $userId,
            'timestamp' => now(),
        ]);
    }
}
