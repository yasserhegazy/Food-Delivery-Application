<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            // Pizza Paradise
            'Pizzas' => [
                ['name' => 'Margherita Pizza', 'price' => 12.99, 'description' => 'Classic tomato sauce, mozzarella, and fresh basil', 'preparation_time' => 15],
                ['name' => 'Pepperoni Pizza', 'price' => 14.99, 'description' => 'Loaded with premium pepperoni and extra cheese', 'preparation_time' => 15],
                ['name' => 'Vegetarian Supreme', 'price' => 15.99, 'description' => 'Bell peppers, mushrooms, onions, olives, and tomatoes', 'preparation_time' => 18],
                ['name' => 'Meat Lovers', 'price' => 17.99, 'discount_price' => 14.99, 'description' => 'Pepperoni, sausage, bacon, and ham', 'preparation_time' => 20, 'is_featured' => true],
            ],
            'Appetizers' => [
                ['name' => 'Garlic Bread', 'price' => 5.99, 'description' => 'Toasted bread with garlic butter and herbs', 'preparation_time' => 8],
                ['name' => 'Mozzarella Sticks', 'price' => 7.99, 'description' => 'Crispy breaded mozzarella with marinara sauce', 'preparation_time' => 10],
            ],
            
            // Burger House
            'Burgers' => [
                ['name' => 'Classic Burger', 'price' => 9.99, 'description' => 'Beef patty, lettuce, tomato, onion, pickles', 'preparation_time' => 12],
                ['name' => 'Cheese Burger', 'price' => 10.99, 'description' => 'Classic burger with melted cheddar cheese', 'preparation_time' => 12],
                ['name' => 'Bacon Burger', 'price' => 12.99, 'description' => 'Topped with crispy bacon and BBQ sauce', 'preparation_time' => 15],
                ['name' => 'Truffle Burger', 'price' => 16.99, 'discount_price' => 13.99, 'description' => 'Premium beef with truffle aioli and arugula', 'preparation_time' => 18, 'is_featured' => true],
            ],
            'Sides' => [
                ['name' => 'French Fries', 'price' => 3.99, 'description' => 'Crispy golden fries', 'preparation_time' => 8],
                ['name' => 'Onion Rings', 'price' => 4.99, 'description' => 'Beer-battered onion rings', 'preparation_time' => 10],
            ],
            
            // Sushi Master
            'Nigiri' => [
                ['name' => 'Salmon Nigiri', 'price' => 5.99, 'description' => 'Fresh salmon over seasoned rice (2 pieces)', 'preparation_time' => 5],
                ['name' => 'Tuna Nigiri', 'price' => 6.99, 'description' => 'Premium tuna over seasoned rice (2 pieces)', 'preparation_time' => 5],
            ],
            'Rolls' => [
                ['name' => 'California Roll', 'price' => 8.99, 'description' => 'Crab, avocado, cucumber (8 pieces)', 'preparation_time' => 10],
                ['name' => 'Spicy Tuna Roll', 'price' => 10.99, 'description' => 'Spicy tuna, cucumber, scallions (8 pieces)', 'preparation_time' => 12],
                ['name' => 'Dragon Roll', 'price' => 14.99, 'discount_price' => 11.99, 'description' => 'Eel, cucumber, avocado topping (8 pieces)', 'preparation_time' => 15, 'is_featured' => true],
            ],
            
            // Taco Fiesta
            'Tacos' => [
                ['name' => 'Beef Tacos', 'price' => 8.99, 'description' => 'Seasoned beef with fresh toppings (3 tacos)', 'preparation_time' => 10],
                ['name' => 'Chicken Tacos', 'price' => 8.99, 'description' => 'Grilled chicken with pico de gallo (3 tacos)', 'preparation_time' => 10],
                ['name' => 'Fish Tacos', 'price' => 10.99, 'description' => 'Crispy fish with cabbage slaw (3 tacos)', 'preparation_time' => 12, 'is_featured' => true],
            ],
            'Burritos' => [
                ['name' => 'Beef Burrito', 'price' => 11.99, 'description' => 'Large burrito with beef, rice, beans, cheese', 'preparation_time' => 12],
                ['name' => 'Veggie Burrito', 'price' => 9.99, 'description' => 'Grilled vegetables, rice, beans, guacamole', 'preparation_time' => 12],
            ],
            
            // Pasta Bella
            'Pasta' => [
                ['name' => 'Spaghetti Carbonara', 'price' => 14.99, 'description' => 'Creamy sauce with pancetta and parmesan', 'preparation_time' => 15],
                ['name' => 'Fettuccine Alfredo', 'price' => 13.99, 'description' => 'Rich cream sauce with parmesan cheese', 'preparation_time' => 15],
                ['name' => 'Penne Arrabbiata', 'price' => 12.99, 'description' => 'Spicy tomato sauce with garlic and chili', 'preparation_time' => 12],
                ['name' => 'Lasagna', 'price' => 16.99, 'discount_price' => 13.99, 'description' => 'Layers of pasta, meat sauce, and cheese', 'preparation_time' => 20, 'is_featured' => true],
            ],
        ];

        $categories = Category::with('restaurant')->get();

        foreach ($categories as $category) {
            if (isset($menuItems[$category->name])) {
                foreach ($menuItems[$category->name] as $index => $itemData) {
                    MenuItem::create([
                        'category_id' => $category->id,
                        'name' => $itemData['name'],
                        'slug' => Str::slug($itemData['name']),
                        'description' => $itemData['description'],
                        'price' => $itemData['price'],
                        'discount_price' => $itemData['discount_price'] ?? null,
                        'preparation_time' => $itemData['preparation_time'] ?? 15,
                        'is_available' => true,
                        'is_featured' => $itemData['is_featured'] ?? false,
                        'sort_order' => $index,
                    ]);
                }
            }
        }
    }
}
