<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */

use App\Models\Restaurant;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $restaurantNames = [
            'Pizza Paradise', 'Sushi Master', 'Burger Haven', 'Taco Fiesta',
            'Pasta Palace', 'Dragon Wok', 'Curry House', 'BBQ Pit',
            'Mediterranean Grill', 'Thai Spice', 'Pho Corner', 'Ramen Bar',
            'Steakhouse Prime', 'Seafood Shack', 'Vegan Delight', 'Breakfast Club',
            'Coffee & Bites', 'Sandwich Shop', 'Salad Bar', 'Dessert Haven'
        ];

        $cuisines = [
            'Italian', 'Japanese', 'American', 'Mexican', 'Chinese',
            'Indian', 'Thai', 'Mediterranean', 'BBQ', 'Seafood',
            'Vegan', 'Breakfast', 'Cafe', 'Fast Food', 'Healthy'
        ];

        $cities = [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
            'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'Austin'
        ];

        $name = fake()->randomElement($restaurantNames) . ' ' . fake()->randomElement(['Bistro', 'Kitchen', 'Restaurant', 'Eatery', '']) . ' ' . fake()->city();
        $name = trim($name);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 100000),
            'description' => fake()->sentence(12),
            'cuisine_type' => fake()->randomElement($cuisines),
            'logo' => null,
            'cover_image' => null,
            'phone' => fake()->phoneNumber(),
            'email' => 'restaurant' . fake()->unique()->numberBetween(1, 100000) . '@' . fake()->safeEmailDomain(),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement($cities),
            'latitude' => fake()->latitude(25, 48),
            'longitude' => fake()->longitude(-125, -65),
            'opening_time' => '09:00:00',
            'closing_time' => '22:00:00',
            'delivery_time' => fake()->numberBetween(20, 60),
            'minimum_order' => fake()->randomFloat(2, 10, 30),
            'delivery_fee' => fake()->randomFloat(2, 2, 10),
            'is_active' => fake()->boolean(90), // 90% active
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'total_reviews' => fake()->numberBetween(10, 500),
        ];
    }
}

