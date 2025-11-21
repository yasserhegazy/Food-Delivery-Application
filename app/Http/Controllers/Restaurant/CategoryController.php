<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()
                ->route('restaurant.profile.edit')
                ->with('error', 'Please create your restaurant profile first.');
        }

        $categories = $restaurant->categories()->ordered()->withCount('menuItems')->get();

        return view('restaurant.categories.index', compact('categories', 'restaurant'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('restaurant.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(CategoryRequest $request)
    {
        $restaurant = auth()->user()->restaurant;

        if (!$restaurant) {
            return back()->with('error', 'Please create your restaurant profile first.');
        }

        $data = $request->validated();
        $data['restaurant_id'] = $restaurant->id;
        $data['slug'] = Str::slug($data['name']);
        $data['sort_order'] = $restaurant->categories()->max('sort_order') + 1;

        Category::create($data);

        return redirect()
            ->route('restaurant.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        // Ensure the category belongs to the authenticated user's restaurant
        if ($category->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        return view('restaurant.categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // Ensure the category belongs to the authenticated user's restaurant
        if ($category->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return redirect()
            ->route('restaurant.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        // Ensure the category belongs to the authenticated user's restaurant
        if ($category->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $category->delete();

        return redirect()
            ->route('restaurant.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * Reorder categories.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'categories' => ['required', 'array'],
            'categories.*.id' => ['required', 'exists:categories,id'],
            'categories.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->categories as $categoryData) {
            Category::where('id', $categoryData['id'])->update([
                'sort_order' => $categoryData['sort_order']
            ]);
        }

        return response()->json(['message' => 'Categories reordered successfully!']);
    }
}
