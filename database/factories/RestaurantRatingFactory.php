<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RestaurantRating>
 */

use App\Models\RestaurantRating;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RestaurantRating>
 */
class RestaurantRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'Great food and excellent service!',
            'Delicious meals, highly recommended.',
            'Fast delivery and hot food.',
            'Amazing taste, will order again.',
            'Good quality for the price.',
            'Fresh ingredients and generous portions.',
            'Best restaurant in town!',
            'Decent food, nothing special.',
            'Could be better, but okay.',
            'Not bad, would try again.',
        ];

        return [
            'rating' => fake()->numberBetween(3, 5), // Mostly positive ratings
            'review' => fake()->randomElement($comments),
        ];
    }
}
