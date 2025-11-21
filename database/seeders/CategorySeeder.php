<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();

        $categoryTemplates = [
            'Pizza Paradise' => ['Pizzas', 'Appetizers', 'Salads', 'Desserts', 'Beverages'],
            'Burger House' => ['Burgers', 'Sides', 'Shakes', 'Desserts'],
            'Sushi Master' => ['Nigiri', 'Rolls', 'Sashimi', 'Appetizers', 'Beverages'],
            'Taco Fiesta' => ['Tacos', 'Burritos', 'Quesadillas', 'Sides', 'Drinks'],
            'Pasta Bella' => ['Pasta', 'Risotto', 'Appetizers', 'Desserts', 'Wine'],
        ];

        foreach ($restaurants as $restaurant) {
            $categories = $categoryTemplates[$restaurant->name] ?? ['Main Dishes', 'Sides', 'Desserts', 'Beverages'];
            
            foreach ($categories as $index => $categoryName) {
                Category::create([
                    'restaurant_id' => $restaurant->id,
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                    'description' => 'Delicious ' . strtolower($categoryName) . ' prepared fresh daily.',
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }
        }
    }
}
