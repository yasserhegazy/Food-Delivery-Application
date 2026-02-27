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
        $restaurantProfiles = [
            [
                'name' => 'The Rustic Kitchen',
                'cuisine' => 'American',
                'description' => 'Farm-fresh comfort food crafted with locally sourced ingredients. Our wood-fired oven and open kitchen bring warmth to every dish we serve.',
            ],
            [
                'name' => 'Sakura Japanese',
                'cuisine' => 'Japanese',
                'description' => 'Authentic Japanese cuisine featuring hand-rolled sushi, delicate sashimi, and traditional ramen prepared by our Tokyo-trained chefs.',
            ],
            [
                'name' => 'El Fuego Mexican Grill',
                'cuisine' => 'Mexican',
                'description' => 'Bold, fiery flavors inspired by the streets of Mexico City. Our handmade tortillas and slow-roasted meats bring the authentic taste of Mexico to your table.',
            ],
            [
                'name' => 'Blue Ocean Seafood',
                'cuisine' => 'Seafood',
                'description' => 'Fresh catches delivered daily from coastal fisheries. From buttery lobster to crispy fish tacos, every bite tastes like the ocean breeze.',
            ],
            [
                'name' => 'Golden Dragon Chinese',
                'cuisine' => 'Chinese',
                'description' => 'Traditional Cantonese and Szechuan dishes wok-tossed to perfection. Our dim sum brunch and Peking duck are neighborhood favorites.',
            ],
            [
                'name' => 'Spice Route Indian',
                'cuisine' => 'Indian',
                'description' => 'A culinary journey through India featuring aromatic curries, tandoori specialties, and freshly baked naan from our clay oven.',
            ],
            [
                'name' => 'The Green Plate Vegan',
                'cuisine' => 'Vegan',
                'description' => 'Plant-powered dining that proves healthy eating is anything but boring. Creative, colorful dishes made entirely from whole foods and organic produce.',
            ],
            [
                'name' => 'Sunrise Breakfast Cafe',
                'cuisine' => 'Breakfast',
                'description' => 'Start your morning right with fluffy pancakes, eggs benedict, and artisan coffee. Serving all-day breakfast favorites with a modern twist.',
            ],
            [
                'name' => 'Smoke & Grill BBQ',
                'cuisine' => 'BBQ',
                'description' => 'Low and slow is our motto. Hickory-smoked brisket, fall-off-the-bone ribs, and homemade sauces that have won regional competitions.',
            ],
            [
                'name' => 'Bella Napoli Pizzeria',
                'cuisine' => 'Italian',
                'description' => 'Neapolitan-style pizza baked in our imported wood-fired oven at 900°F. Topped with San Marzano tomatoes and fresh mozzarella di bufala.',
            ],
            [
                'name' => 'Le Petit Bistro',
                'cuisine' => 'French',
                'description' => 'A charming French bistro offering classic dishes like coq au vin, duck confit, and crème brûlée in an intimate candlelit setting.',
            ],
            [
                'name' => 'Thai Orchid',
                'cuisine' => 'Thai',
                'description' => 'Vibrant Thai flavors balancing sweet, sour, salty, and spicy. Our pad thai, green curry, and mango sticky rice transport you to Bangkok.',
            ],
            [
                'name' => 'Seoul Kitchen Korean',
                'cuisine' => 'Korean',
                'description' => 'Modern Korean cuisine featuring sizzling bibimbap, crispy Korean fried chicken, and tableside BBQ with premium marinated meats.',
            ],
            [
                'name' => 'Mediterranean Oasis',
                'cuisine' => 'Mediterranean',
                'description' => 'Sun-kissed Mediterranean flavors from Greece, Turkey, and Lebanon. Savor our hummus platters, grilled halloumi, and herb-crusted lamb.',
            ],
            [
                'name' => 'The Burger Joint',
                'cuisine' => 'American',
                'description' => 'Gourmet burgers made with dry-aged beef, brioche buns, and creative toppings. Paired with hand-cut fries and thick milkshakes.',
            ],
            [
                'name' => 'Pho 99 Vietnamese',
                'cuisine' => 'Vietnamese',
                'description' => 'Soul-warming pho simmered for 24 hours, crispy banh mi sandwiches, and fresh spring rolls. A taste of Saigon in every bowl.',
            ],
            [
                'name' => 'Sweet Tooth Bakery',
                'cuisine' => 'Bakery',
                'description' => 'Artisan pastries, decadent cakes, and freshly baked breads made from scratch daily. Our croissants and macarons are worth the trip alone.',
            ],
            [
                'name' => 'Havana Cuban Kitchen',
                'cuisine' => 'Cuban',
                'description' => 'The soul of Havana on your plate. Slow-roasted pork, black beans and rice, and crispy tostones served with our signature mojito sauce.',
            ],
            [
                'name' => 'Ambrosia Greek',
                'cuisine' => 'Greek',
                'description' => 'Classic Greek taverna fare featuring gyros carved from the spit, flaky spanakopita, and the freshest Greek salads dressed in extra virgin olive oil.',
            ],
            [
                'name' => 'Farm to Table Organic',
                'cuisine' => 'Healthy',
                'description' => 'Seasonal menus built around organic, locally harvested ingredients. Every dish celebrates the natural flavors of sustainable farming.',
            ],
        ];

        $profile = fake()->randomElement($restaurantProfiles);

        $cities = [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
            'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'Austin'
        ];

        $coverImages = [
            'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800&q=80',
            'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=800&q=80',
            'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=800&q=80',
            'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=800&q=80',
            'https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=800&q=80',
            'https://images.unsplash.com/photo-1537047902294-62a40c20a6ae?w=800&q=80',
            'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80',
            'https://images.unsplash.com/photo-1544148103-0773bf10d330?w=800&q=80',
            'https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=800&q=80',
            'https://images.unsplash.com/photo-1578474846511-04ba529f0b88?w=800&q=80',
        ];

        $logos = [
            'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=200&q=80',
            'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200&q=80',
            'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=200&q=80',
            'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=200&q=80',
            'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=200&q=80',
            'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?w=200&q=80',
            'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=200&q=80',
            'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=200&q=80',
        ];

        $name = $profile['name'];

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 100000),
            'description' => $profile['description'],
            'cuisine_type' => $profile['cuisine'],
            'logo' => fake()->randomElement($logos),
            'cover_image' => fake()->randomElement($coverImages),
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
            'is_active' => fake()->boolean(90),
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'total_reviews' => fake()->numberBetween(10, 500),
        ];
    }
}

