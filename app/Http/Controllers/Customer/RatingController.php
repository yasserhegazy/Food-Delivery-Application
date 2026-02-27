<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\RestaurantRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store a new rating.
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate(RestaurantRating::rules());

        try {
            $rating = RestaurantRating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'restaurant_id' => $restaurant->id,
                ],
                [
                    'rating' => $request->rating,
                    'review' => $request->review,
                ]
            );

            // Update restaurant average rating
            $this->updateRestaurantRating($restaurant);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your rating!',
                    'rating' => $rating,
                ]);
            }

            return redirect()->back()->with('success', 'Thank you for your rating!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit rating.',
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to submit rating.');
        }
    }

    /**
     * Update an existing rating.
     */
    public function update(Request $request, RestaurantRating $rating)
    {
        // Ensure the rating belongs to the authenticated user
        if ($rating->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate(RestaurantRating::rules());

        try {
            $rating->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            // Update restaurant average rating
            $this->updateRestaurantRating($rating->restaurant);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rating updated!',
                    'rating' => $rating,
                ]);
            }

            return redirect()->back()->with('success', 'Rating updated!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update rating.',
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update rating.');
        }
    }

    /**
     * Delete a rating.
     */
    public function destroy(RestaurantRating $rating)
    {
        // Ensure the rating belongs to the authenticated user
        if ($rating->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $restaurant = $rating->restaurant;
            $rating->delete();

            // Update restaurant average rating
            $this->updateRestaurantRating($restaurant);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rating deleted!',
                ]);
            }

            return redirect()->back()->with('success', 'Rating deleted!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete rating.',
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete rating.');
        }
    }

    /**
     * Rate the driver for a delivered order.
     */
    public function rateDriver(Request $request, Order $order)
    {
        $request->validate([
            'driver_rating' => 'required|integer|min:1|max:5',
            'driver_review' => 'nullable|string|max:500',
        ]);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (is_null($order->driver_id)) {
            return redirect()->back()->with('error', 'This order has no assigned driver.');
        }

        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'You can only rate delivered orders.');
        }

        $order->update([
            'driver_rating' => $request->driver_rating,
            'driver_review' => $request->driver_review,
        ]);

        return redirect()->back()->with('success', 'Thank you for rating your driver!');
    }

    /**
     * Update restaurant's average rating and total reviews.
     */
    protected function updateRestaurantRating(Restaurant $restaurant): void
    {
        $ratings = $restaurant->ratings;
        
        $restaurant->update([
            'rating' => $ratings->avg('rating') ?? 0,
            'total_reviews' => $ratings->count(),
        ]);
    }
}
