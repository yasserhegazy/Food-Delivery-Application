<?php

namespace Tests\Feature\Customer;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function setupCartForCustomer(User $customer): array
    {
        $owner = User::factory()->create(['role' => 'restaurant_owner']);
        $restaurant = Restaurant::factory()->create(['user_id' => $owner->id]);
        $category = Category::factory()->create(['restaurant_id' => $restaurant->id]);
        $menuItem = MenuItem::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
            'price' => 15.00,
        ]);

        $cartItem = CartItem::create([
            'user_id' => $customer->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => 2,
            'price' => $menuItem->price,
        ]);

        $address = Address::factory()->create([
            'user_id' => $customer->id,
            'is_default' => true,
        ]);

        return compact('restaurant', 'menuItem', 'cartItem', 'address', 'owner');
    }

    public function test_checkout_page_loads_for_authenticated_customer(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $this->setupCartForCustomer($customer);

        $response = $this->actingAs($customer)->get(route('customer.checkout.index'));

        $response->assertStatus(200);
    }

    public function test_customer_can_place_an_order(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $data = $this->setupCartForCustomer($customer);

        $response = $this->actingAs($customer)->post(route('customer.checkout.store'), [
            'address_id' => $data['address']->id,
            'special_instructions' => 'No onions please',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'restaurant_id' => $data['restaurant']->id,
            'status' => 'pending',
        ]);
    }

    public function test_checkout_requires_address_selection(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $this->setupCartForCustomer($customer);

        $response = $this->actingAs($customer)->post(route('customer.checkout.store'), [
            'special_instructions' => 'Test',
        ]);

        $response->assertSessionHasErrors('address_id');
    }

    public function test_unauthenticated_user_cannot_access_checkout(): void
    {
        $response = $this->get(route('customer.checkout.index'));

        $response->assertRedirect(route('login'));
    }
}
