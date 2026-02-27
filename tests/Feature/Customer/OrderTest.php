<?php

namespace Tests\Feature\Customer;

use App\Models\Address;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private function createOrder(User $customer): Order
    {
        $owner = User::factory()->create(['role' => 'restaurant_owner']);
        $restaurant = Restaurant::factory()->create(['user_id' => $owner->id]);
        $address = Address::factory()->create(['user_id' => $customer->id]);

        return Order::create([
            'user_id' => $customer->id,
            'restaurant_id' => $restaurant->id,
            'delivery_address_id' => $address->id,
            'total_amount' => 30.00,
            'status' => 'pending',
        ]);
    }

    public function test_customer_can_view_their_orders(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $this->createOrder($customer);

        $response = $this->actingAs($customer)->get(route('customer.orders.index'));

        $response->assertStatus(200);
    }

    public function test_customer_can_view_order_detail(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $order = $this->createOrder($customer);

        $response = $this->actingAs($customer)->get(route('customer.orders.show', $order));

        $response->assertStatus(200);
    }

    public function test_customer_cannot_view_other_users_order(): void
    {
        $customer1 = User::factory()->create(['role' => 'customer']);
        $customer2 = User::factory()->create(['role' => 'customer']);
        $order = $this->createOrder($customer1);

        $response = $this->actingAs($customer2)->get(route('customer.orders.show', $order));

        $response->assertStatus(403);
    }
}
