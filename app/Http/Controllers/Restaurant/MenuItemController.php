<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{
    /**
     * Display a listing of menu items.
     */
    public function index(Request $request)
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()
                ->route('restaurant.profile.edit')
                ->with('error', 'Please create your restaurant profile first.');
        }

        $query = MenuItem::whereHas('category', function ($q) use ($restaurant) {
            $q->where('restaurant_id', $restaurant->id);
        })->with('category');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menuItems = $query->ordered()->paginate(20);
        $categories = $restaurant->categories;

        return view('restaurant.menu.index', compact('menuItems', 'categories', 'restaurant'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()
                ->route('restaurant.profile.edit')
                ->with('error', 'Please create your restaurant profile first.');
        }

        $categories = $restaurant->categories;

        return view('restaurant.menu.create', compact('categories'));
    }

    /**
     * Store a newly created menu item.
     */
    public function store(MenuItemRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu-items', 'public');
        }

        // Set sort order
        $data['sort_order'] = MenuItem::where('category_id', $data['category_id'])
            ->max('sort_order') + 1;

        MenuItem::create($data);

        return redirect()
            ->route('restaurant.menu.index')
            ->with('success', 'Menu item created successfully!');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menu)
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.profile.edit')
                ->with('error', 'Please create your restaurant profile first.');
        }
        
        // Load category to verify ownership
        $menu->load('category');
        
        // Verify the menu item belongs to a category owned by this restaurant
        if (!$menu->category || $menu->category->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized access to this menu item.');
        }

        $categories = $restaurant->categories;
        $menuItem = $menu; // For backward compatibility with view

        return view('restaurant.menu.edit', compact('menuItem', 'categories'));
    }

    /**
     * Update the specified menu item.
     */
    public function update(MenuItemRequest $request, MenuItem $menu)
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.profile.edit')
                ->with('error', 'Please create your restaurant profile first.');
        }
        
        // Load category to verify ownership
        $menu->load('category');
        
        // Verify the menu item belongs to a category owned by this restaurant
        if (!$menu->category || $menu->category->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized access to this menu item.');
        }

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $menu->update($data);

        return redirect()
            ->route('restaurant.menu.index')
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item.
     */
    public function destroy(MenuItem $menu)
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.profile.edit')
                ->with('error', 'Please create your restaurant profile first.');
        }
        
        // Load category to verify ownership
        $menu->load('category');
        
        // Verify the menu item belongs to a category owned by this restaurant
        if (!$menu->category || $menu->category->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized access to this menu item.');
        }

        $menu->delete();

        return redirect()
            ->route('restaurant.menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }

    /**
     * Toggle menu item availability.
     */
    public function toggleAvailability(MenuItem $menu)
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant profile not found'], 403);
        }
        
        // Load category to verify ownership
        $menu->load('category');
        
        // Verify the menu item belongs to a category owned by this restaurant
        if (!$menu->category || $menu->category->restaurant_id !== $restaurant->id) {
            return response()->json(['error' => 'Unauthorized access to this menu item.'], 403);
        }

        $menu->toggleAvailability();

        return response()->json([
            'success' => true,
            'is_available' => $menu->is_available,
            'message' => 'Availability updated successfully!'
        ]);
    }
}
