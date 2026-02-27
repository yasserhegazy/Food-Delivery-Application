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
                ['name' => 'Margherita Pizza', 'price' => 12.99, 'description' => 'Classic tomato sauce, mozzarella, and fresh basil', 'preparation_time' => 15, 'image' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=400&q=80'],
                ['name' => 'Pepperoni Pizza', 'price' => 14.99, 'description' => 'Loaded with premium pepperoni and extra cheese', 'preparation_time' => 15, 'image' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=400&q=80'],
                ['name' => 'Vegetarian Supreme', 'price' => 15.99, 'description' => 'Bell peppers, mushrooms, onions, olives, and tomatoes', 'preparation_time' => 18, 'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&q=80'],
                ['name' => 'Meat Lovers', 'price' => 17.99, 'discount_price' => 14.99, 'description' => 'Pepperoni, sausage, bacon, and ham', 'preparation_time' => 20, 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400&q=80'],
            ],
            'Appetizers' => [
                ['name' => 'Garlic Bread', 'price' => 5.99, 'description' => 'Toasted bread with garlic butter and herbs', 'preparation_time' => 8, 'image' => 'https://images.unsplash.com/photo-1619535860434-ba1d8fa12536?w=400&q=80'],
                ['name' => 'Mozzarella Sticks', 'price' => 7.99, 'description' => 'Crispy breaded mozzarella with marinara sauce', 'preparation_time' => 10, 'image' => 'https://images.unsplash.com/photo-1531749668029-2db88e4276c7?w=400&q=80'],
            ],
            
            // Burger House
            'Burgers' => [
                ['name' => 'Classic Burger', 'price' => 9.99, 'description' => 'Beef patty, lettuce, tomato, onion, pickles', 'preparation_time' => 12, 'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&q=80'],
                ['name' => 'Cheese Burger', 'price' => 10.99, 'description' => 'Classic burger with melted cheddar cheese', 'preparation_time' => 12, 'image' => 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=400&q=80'],
                ['name' => 'Bacon Burger', 'price' => 12.99, 'description' => 'Topped with crispy bacon and BBQ sauce', 'preparation_time' => 15, 'image' => 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?w=400&q=80'],
                ['name' => 'Truffle Burger', 'price' => 16.99, 'discount_price' => 13.99, 'description' => 'Premium beef with truffle aioli and arugula', 'preparation_time' => 18, 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1551782450-a2132b4ba21d?w=400&q=80'],
            ],
            'Sides' => [
                ['name' => 'French Fries', 'price' => 3.99, 'description' => 'Crispy golden fries', 'preparation_time' => 8, 'image' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=400&q=80'],
                ['name' => 'Onion Rings', 'price' => 4.99, 'description' => 'Beer-battered onion rings', 'preparation_time' => 10, 'image' => 'https://images.unsplash.com/photo-1639024471283-03518883512d?w=400&q=80'],
            ],
            
            // Sushi Master
            'Nigiri' => [
                ['name' => 'Salmon Nigiri', 'price' => 5.99, 'description' => 'Fresh salmon over seasoned rice (2 pieces)', 'preparation_time' => 5, 'image' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=400&q=80'],
                ['name' => 'Tuna Nigiri', 'price' => 6.99, 'description' => 'Premium tuna over seasoned rice (2 pieces)', 'preparation_time' => 5, 'image' => 'https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?w=400&q=80'],
            ],
            'Rolls' => [
                ['name' => 'California Roll', 'price' => 8.99, 'description' => 'Crab, avocado, cucumber (8 pieces)', 'preparation_time' => 10, 'image' => 'https://images.unsplash.com/photo-1553621042-f6e147245754?w=400&q=80'],
                ['name' => 'Spicy Tuna Roll', 'price' => 10.99, 'description' => 'Spicy tuna, cucumber, scallions (8 pieces)', 'preparation_time' => 12, 'image' => 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?w=400&q=80'],
                ['name' => 'Dragon Roll', 'price' => 14.99, 'discount_price' => 11.99, 'description' => 'Eel, cucumber, avocado topping (8 pieces)', 'preparation_time' => 15, 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1583623025817-d180a2221d0a?w=400&q=80'],
            ],
            
            // Taco Fiesta
            'Tacos' => [
                ['name' => 'Beef Tacos', 'price' => 8.99, 'description' => 'Seasoned beef with fresh toppings (3 tacos)', 'preparation_time' => 10, 'image' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=400&q=80'],
                ['name' => 'Chicken Tacos', 'price' => 8.99, 'description' => 'Grilled chicken with pico de gallo (3 tacos)', 'preparation_time' => 10, 'image' => 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=400&q=80'],
                ['name' => 'Fish Tacos', 'price' => 10.99, 'description' => 'Crispy fish with cabbage slaw (3 tacos)', 'preparation_time' => 12, 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1512838243594-988d3bd20695?w=400&q=80'],
            ],
            'Burritos' => [
                ['name' => 'Beef Burrito', 'price' => 11.99, 'description' => 'Large burrito with beef, rice, beans, cheese', 'preparation_time' => 12, 'image' => 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=400&q=80'],
                ['name' => 'Veggie Burrito', 'price' => 9.99, 'description' => 'Grilled vegetables, rice, beans, guacamole', 'preparation_time' => 12, 'image' => 'https://images.unsplash.com/photo-1584208632869-05fa2b2a5934?w=400&q=80'],
            ],
            
            // Pasta Bella
            'Pasta' => [
                ['name' => 'Spaghetti Carbonara', 'price' => 14.99, 'description' => 'Creamy sauce with pancetta and parmesan', 'preparation_time' => 15, 'image' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=400&q=80'],
                ['name' => 'Fettuccine Alfredo', 'price' => 13.99, 'description' => 'Rich cream sauce with parmesan cheese', 'preparation_time' => 15, 'image' => 'https://images.unsplash.com/photo-1645112411341-6c4fd023714a?w=400&q=80'],
                ['name' => 'Penne Arrabbiata', 'price' => 12.99, 'description' => 'Spicy tomato sauce with garlic and chili', 'preparation_time' => 12, 'image' => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=400&q=80'],
                ['name' => 'Lasagna', 'price' => 16.99, 'discount_price' => 13.99, 'description' => 'Layers of pasta, meat sauce, and cheese', 'preparation_time' => 20, 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=400&q=80'],
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
                        'image' => $itemData['image'] ?? null,
                        'is_available' => true,
                        'is_featured' => $itemData['is_featured'] ?? false,
                        'sort_order' => $index,
                    ]);
                }
            }
        }
    }
}
