<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */

use App\Models\MenuItem;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $menuItems = [
            'Margherita Pizza', 'Pepperoni Pizza', 'Caesar Salad', 'Greek Salad',
            'Chicken Wings', 'Mozzarella Sticks', 'French Fries', 'Onion Rings',
            'Cheeseburger', 'Bacon Burger', 'Veggie Burger', 'Grilled Chicken',
            'Fried Chicken', 'Fish and Chips', 'Shrimp Scampi', 'Salmon Fillet',
            'Spaghetti Carbonara', 'Fettuccine Alfredo', 'Lasagna', 'Ravioli',
            'Chicken Tacos', 'Beef Tacos', 'Fish Tacos', 'Burrito Bowl',
            'Pad Thai', 'Fried Rice', 'Lo Mein', 'Spring Rolls',
            'Sushi Roll', 'Sashimi', 'Tempura', 'Ramen Bowl',
            'Chocolate Cake', 'Cheesecake', 'Ice Cream', 'Brownie',
            'Coca Cola', 'Sprite', 'Orange Juice', 'Iced Tea', 'Coffee', 'Latte'
        ];

        $images = [
            'menu-items/pizza.png',
            'menu-items/burger.jpg',
            'menu-items/sushi-roll.png',
        ];

        $name = fake()->randomElement($menuItems);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 10000),
            'description' => fake()->sentence(8),
            'price' => fake()->randomFloat(2, 5, 50),
            'image' => fake()->randomElement($images),
            'is_available' => fake()->boolean(90), // 90% available
        ];
    }
}
