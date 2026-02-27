<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $restaurants = auth()->user()->favoriteRestaurants()->active()->latest('favorites.created_at')->get();

        return view('customer.favorites.index', compact('restaurants'));
    }

    public function toggle(Restaurant $restaurant)
    {
        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('restaurant_id', $restaurant->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'restaurant_id' => $restaurant->id,
            ]);
            $favorited = true;
        }

        return response()->json([
            'favorited' => $favorited,
            'count' => $user->favorites()->count(),
        ]);
    }
}
