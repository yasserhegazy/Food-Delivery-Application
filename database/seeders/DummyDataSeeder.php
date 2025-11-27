<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantRating;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $this->command->info('🌱 Starting dummy data generation...');

            // 1. Create Customers
            $this->command->info('Creating 50 customers...');
            $customers = User::factory()->count(50)->create(['role' => 'customer']);

            // 2. Create Drivers
            $this->command->info('Creating 15 drivers...');
            $drivers = User::factory()->count(15)->create([
                'role' => 'driver',
                'is_active' => true,
            ]);

            // 3. Create Admin (if doesn't exist)
            $this->command->info('Creating 1 admin...');
            if (!User::where('email', 'admin@fooddelivery.com')->exists()) {
                User::factory()->create([
                    'role' => 'admin',
                    'name' => 'Admin User',
                    'email' => 'admin@fooddelivery.com',
                ]);
            }

            // 4. Create Restaurants with Owners
            $this->command->info('Creating 20 restaurants with owners...');
            $restaurants = collect();
            for ($i = 0; $i < 20; $i++) {
                $owner = User::factory()->create(['role' => 'restaurant_owner']);
                $restaurant = Restaurant::factory()->create(['user_id' => $owner->id]);
                $restaurants->push($restaurant);
            }

            // 5. Create Categories and Menu Items
            $this->command->info('Creating categories and menu items...');
            $allMenuItems = collect();
            
            foreach ($restaurants as $restaurant) {
                $categoryCount = rand(8, 15);
                
                for ($i = 0; $i < $categoryCount; $i++) {
                    $category = Category::factory()->create([
                        'restaurant_id' => $restaurant->id,
                        'sort_order' => $i + 1,
                    ]);

                    $itemCount = rand(20, 35);
                    $menuItems = MenuItem::factory()->count($itemCount)->create([
                        'category_id' => $category->id,
                    ]);

                    $allMenuItems = $allMenuItems->merge($menuItems);
                }
            }

            $this->command->info("Created {$allMenuItems->count()} menu items");

            // 6. Create Addresses for Customers
            $this->command->info('Creating addresses for customers...');
            foreach ($customers as $customer) {
                $addressCount = rand(3, 5);
                Address::factory()->count($addressCount)->create([
                    'user_id' => $customer->id,
                ]);
            }

            // 7. Create Orders with Items
            $this->command->info('Creating 500-1000 orders...');
            $orderCount = rand(500, 1000);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $customer = $customers->random();
                $restaurant = $restaurants->random();
                $address = $customer->addresses()->inRandomOrder()->first();
                
                if (!$address) {
                    $address = Address::factory()->create(['user_id' => $customer->id]);
                }

                // Get random date (weighted towards recent)
                $createdAt = $this->getRandomDate();
                
                // Get weighted status
                $status = $this->getWeightedStatus();
                
                // Assign driver for delivered/on_way orders
                $driverId = in_array($status, ['delivered', 'on_way']) 
                    ? $drivers->random()->id 
                    : null;

                // Create order
                $order = Order::create([
                    'user_id' => $customer->id,
                    'restaurant_id' => $restaurant->id,
                    'delivery_address_id' => $address->id,
                    'driver_id' => $driverId,
                    'status' => $status,
                    'total_amount' => 0, // Will calculate after adding items
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Add 2-5 items to order
                $itemCount = rand(2, 5);
                $restaurantMenuItems = $allMenuItems->where('category.restaurant_id', $restaurant->id);
                
                if ($restaurantMenuItems->isEmpty()) {
                    $restaurantMenuItems = MenuItem::whereHas('category', function($q) use ($restaurant) {
                        $q->where('restaurant_id', $restaurant->id);
                    })->get();
                }

                $totalAmount = 0;
                for ($j = 0; $j < $itemCount; $j++) {
                    $menuItem = $restaurantMenuItems->random();
                    $quantity = rand(1, 3);
                    $price = $menuItem->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $menuItem->id,
                        'name' => $menuItem->name,
                        'price' => $price,
                        'quantity' => $quantity,
                    ]);

                    $totalAmount += $price * $quantity;
                }

                // Update order total
                $order->update(['total_amount' => $totalAmount]);
            }

            // 8. Create Restaurant Ratings
            $this->command->info('Creating 100-200 restaurant ratings...');
            $ratingCount = rand(100, 200);
            $created = 0;
            
            while ($created < $ratingCount) {
                $customer = $customers->random();
                $restaurant = $restaurants->random();

                // Check if rating already exists
                $exists = RestaurantRating::where('user_id', $customer->id)
                    ->where('restaurant_id', $restaurant->id)
                    ->exists();

                if (!$exists) {
                    RestaurantRating::factory()->create([
                        'user_id' => $customer->id,
                        'restaurant_id' => $restaurant->id,
                        'created_at' => $this->getRandomDate(),
                    ]);
                    $created++;
                }
            }

            $this->command->info('✅ Dummy data generation completed!');
            $this->command->info("📊 Summary:");
            $this->command->info("   - Users: " . User::count());
            $this->command->info("   - Restaurants: " . Restaurant::count());
            $this->command->info("   - Categories: " . Category::count());
            $this->command->info("   - Menu Items: " . MenuItem::count());
            $this->command->info("   - Addresses: " . Address::count());
            $this->command->info("   - Orders: " . Order::count());
            $this->command->info("   - Order Items: " . OrderItem::count());
            $this->command->info("   - Ratings: " . RestaurantRating::count());
        });
    }

    /**
     * Get random date weighted towards recent dates.
     */
    private function getRandomDate(): Carbon
    {
        $weight = rand(1, 100);
        
        if ($weight <= 50) {
            // Last 30 days (50%)
            return Carbon::now()->subDays(rand(0, 30));
        } elseif ($weight <= 80) {
            // 31-60 days (30%)
            return Carbon::now()->subDays(rand(31, 60));
        } else {
            // 61-90 days (20%)
            return Carbon::now()->subDays(rand(61, 90));
        }
    }

    /**
     * Get weighted order status.
     */
    private function getWeightedStatus(): string
    {
        $rand = rand(1, 100);
        
        if ($rand <= 60) return 'delivered';
        if ($rand <= 70) return 'on_way';
        if ($rand <= 75) return 'ready_for_pickup';
        if ($rand <= 80) return 'preparing';
        if ($rand <= 85) return 'confirmed';
        if ($rand <= 95) return 'pending';
        return 'cancelled';
    }
}
