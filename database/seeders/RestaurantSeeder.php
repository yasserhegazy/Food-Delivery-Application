<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'Pizza Paradise',
                'description' => 'Authentic Italian pizzas made with fresh ingredients and traditional recipes. Family-owned since 1995.',
                'cuisine_type' => 'Italian',
                'phone' => '+1 (555) 123-4567',
                'email' => 'info@pizzaparadise.com',
                'address' => '123 Main Street',
                'city' => 'New York',
                'opening_time' => '11:00',
                'closing_time' => '23:00',
                'delivery_time' => 30,
                'minimum_order' => 15.00,
                'delivery_fee' => 3.99,
                'rating' => 4.5,
                'total_reviews' => 234,
            ],
            [
                'name' => 'Burger House',
                'description' => 'Juicy gourmet burgers with premium ingredients. Try our signature truffle burger!',
                'cuisine_type' => 'American',
                'phone' => '+1 (555) 234-5678',
                'email' => 'hello@burgerhouse.com',
                'address' => '456 Oak Avenue',
                'city' => 'New York',
                'opening_time' => '10:00',
                'closing_time' => '22:00',
                'delivery_time' => 25,
                'minimum_order' => 12.00,
                'delivery_fee' => 2.99,
                'rating' => 4.7,
                'total_reviews' => 189,
            ],
            [
                'name' => 'Sushi Master',
                'description' => 'Fresh sushi and Japanese cuisine prepared by experienced chefs. Daily fresh fish delivery.',
                'cuisine_type' => 'Japanese',
                'phone' => '+1 (555) 345-6789',
                'email' => 'contact@sushimaster.com',
                'address' => '789 Park Lane',
                'city' => 'Los Angeles',
                'opening_time' => '12:00',
                'closing_time' => '22:30',
                'delivery_time' => 35,
                'minimum_order' => 20.00,
                'delivery_fee' => 4.99,
                'rating' => 4.8,
                'total_reviews' => 312,
            ],
            [
                'name' => 'Taco Fiesta',
                'description' => 'Authentic Mexican street food with bold flavors. Everything made fresh daily!',
                'cuisine_type' => 'Mexican',
                'phone' => '+1 (555) 456-7890',
                'email' => 'info@tacofiesta.com',
                'address' => '321 Sunset Boulevard',
                'city' => 'Los Angeles',
                'opening_time' => '11:00',
                'closing_time' => '23:00',
                'delivery_time' => 20,
                'minimum_order' => 10.00,
                'delivery_fee' => 2.49,
                'rating' => 4.6,
                'total_reviews' => 156,
            ],
            [
                'name' => 'Pasta Bella',
                'description' => 'Homemade pasta and classic Italian dishes. Nonna\'s recipes passed down through generations.',
                'cuisine_type' => 'Italian',
                'phone' => '+1 (555) 567-8901',
                'email' => 'hello@pastabella.com',
                'address' => '654 Broadway',
                'city' => 'Chicago',
                'opening_time' => '12:00',
                'closing_time' => '22:00',
                'delivery_time' => 30,
                'minimum_order' => 18.00,
                'delivery_fee' => 3.49,
                'rating' => 4.4,
                'total_reviews' => 98,
            ],
        ];

        foreach ($restaurants as $restaurantData) {
            // Create a restaurant owner user
            $user = User::create([
                'name' => $restaurantData['name'] . ' Owner',
                'email' => 'owner_' . Str::slug($restaurantData['name']) . '@example.com',
                'password' => bcrypt('password'),
                'role' => 'restaurant_owner',
                'phone' => $restaurantData['phone'],
                'is_active' => true,
            ]);

            // Create the restaurant
            $restaurantData['user_id'] = $user->id;
            $restaurantData['slug'] = Str::slug($restaurantData['name']);
            $restaurantData['is_active'] = true;

            Restaurant::create($restaurantData);
        }
    }
}
