<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */

use App\Models\Category;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryNames = [
            'Appetizers', 'Starters', 'Soups', 'Salads',
            'Main Course', 'Entrees', 'Pasta', 'Pizza',
            'Burgers', 'Sandwiches', 'Wraps', 'Tacos',
            'Seafood', 'Steaks', 'Chicken', 'Vegetarian',
            'Vegan Options', 'Sides', 'Desserts', 'Beverages',
            'Hot Drinks', 'Cold Drinks', 'Smoothies', 'Specials'
        ];

        $name = fake()->randomElement($categoryNames);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 1000),
            'description' => fake()->optional()->sentence(),
            'sort_order' => 0, // Will be set by seeder
        ];
    }
}
