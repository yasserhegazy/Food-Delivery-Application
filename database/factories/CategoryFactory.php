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
        $categories = [
            ['name' => 'Appetizers', 'description' => 'Start your meal with our tempting selection of small bites and shareable plates.'],
            ['name' => 'Main Course', 'description' => 'Hearty and satisfying entrées crafted with the finest ingredients.'],
            ['name' => 'Desserts', 'description' => 'Indulgent sweets and treats to finish your meal on a high note.'],
            ['name' => 'Beverages', 'description' => 'Refreshing drinks from hand-crafted cocktails to fresh-pressed juices.'],
            ['name' => 'Sides', 'description' => 'Perfect accompaniments to complement any entrée.'],
            ['name' => 'Salads', 'description' => 'Crisp, fresh salads made with seasonal greens and house-made dressings.'],
            ['name' => 'Soups', 'description' => 'Comforting soups simmered to perfection, served piping hot.'],
            ['name' => 'Specials', 'description' => 'Chef-curated dishes available for a limited time — don\'t miss out!'],
            ['name' => 'Kids Menu', 'description' => 'Fun and nutritious meals sized just right for our younger guests.'],
            ['name' => 'Breakfast', 'description' => 'Rise and shine with our morning favorites, from fluffy pancakes to hearty omelets.'],
            ['name' => 'Lunch Specials', 'description' => 'Midday combos and quick bites perfect for your lunch break.'],
            ['name' => 'Pizza', 'description' => 'Hand-tossed pizzas baked in our wood-fired oven with premium toppings.'],
            ['name' => 'Burgers', 'description' => 'Gourmet burgers made with premium beef, creative toppings, and artisan buns.'],
            ['name' => 'Sushi & Rolls', 'description' => 'Fresh sushi, sashimi, and specialty rolls prepared by our expert sushi chefs.'],
            ['name' => 'Pasta', 'description' => 'Classic and contemporary pasta dishes made with imported Italian ingredients.'],
            ['name' => 'Seafood', 'description' => 'The freshest catches from ocean to plate, grilled, fried, or steamed to order.'],
        ];

        $category = fake()->randomElement($categories);

        return [
            'name' => $category['name'],
            'slug' => Str::slug($category['name']) . '-' . fake()->unique()->numberBetween(1, 1000),
            'description' => $category['description'],
            'sort_order' => 0, // Will be set by seeder
        ];
    }
}
