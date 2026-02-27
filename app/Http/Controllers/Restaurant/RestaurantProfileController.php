<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRestaurantProfileRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantProfileController extends Controller
{
    /**
     * Show the form for editing the restaurant profile.
     */
    public function edit()
    {
        $restaurant = auth()->user()->restaurant ?? new Restaurant();
        
        return view('restaurant.profile.edit', compact('restaurant'));
    }

    /**
     * Update the restaurant profile.
     */
    public function update(UpdateRestaurantProfileRequest $request)
    {
        $user = auth()->user();
        $restaurant = $user->restaurant;

        $data = $request->validated();
        
        // Generate slug from name if creating new restaurant
        if (!$restaurant) {
            $data['slug'] = Str::slug($data['name']);
            $data['user_id'] = $user->id;
            $restaurant = Restaurant::create($data);
        } else {
            // Update slug if name changed
            if ($restaurant->name !== $data['name']) {
                $data['slug'] = Str::slug($data['name']);
            }
            $restaurant->update($data);
        }

        return redirect()
            ->route('restaurant.profile.edit')
            ->with('success', 'Restaurant profile updated successfully!');
    }

    /**
     * Upload restaurant logo.
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $restaurant = auth()->user()->restaurant;

        if (!$restaurant) {
            return back()->with('error', 'Please create your restaurant profile first.');
        }

        // Delete old logo
        if ($restaurant->logo) {
            Storage::disk('public')->delete($restaurant->logo);
        }

        // Store new logo
        $path = $request->file('logo')->store('restaurants/logos', 'public');
        $restaurant->update(['logo' => $path]);

        return back()->with('success', 'Logo uploaded successfully!');
    }

    /**
     * Upload restaurant cover image.
     */
    public function uploadCover(Request $request)
    {
        $request->validate([
            'cover_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        $restaurant = auth()->user()->restaurant;

        if (!$restaurant) {
            return back()->with('error', 'Please create your restaurant profile first.');
        }

        // Delete old cover
        if ($restaurant->cover_image) {
            Storage::disk('public')->delete($restaurant->cover_image);
        }

        // Store new cover
        $path = $request->file('cover_image')->store('restaurants/covers', 'public');
        $restaurant->update(['cover_image' => $path]);

        return back()->with('success', 'Cover image uploaded successfully!');
    }
}
