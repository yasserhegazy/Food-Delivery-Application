<?php

namespace Tests\Feature\Customer;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private function createMenuItem(): MenuItem
    {
        $owner = User::factory()->create(['role' => 'restaurant_owner']);
        $restaurant = Restaurant::factory()->create(['user_id' => $owner->id]);
        $category = Category::factory()->create(['restaurant_id' => $restaurant->id]);

        return MenuItem::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
            'price' => 12.99,
        ]);
    }

    public function test_customer_can_add_item_to_cart(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $menuItem = $this->createMenuItem();

        $response = $this->actingAs($customer)->postJson(route('customer.cart.add'), [
            'menu_item_id' => $menuItem->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $customer->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => 2,
        ]);
    }

    public function test_customer_can_update_cart_quantity(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $menuItem = $this->createMenuItem();

        $cartItem = CartItem::create([
            'user_id' => $customer->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => 1,
            'price' => $menuItem->price,
        ]);

        $response = $this->actingAs($customer)->patchJson(route('customer.cart.update', $cartItem->id), [
            'quantity' => 5,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 5,
        ]);
    }

    public function test_customer_can_remove_item_from_cart(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $menuItem = $this->createMenuItem();

        $cartItem = CartItem::create([
            'user_id' => $customer->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => 1,
            'price' => $menuItem->price,
        ]);

        $response = $this->actingAs($customer)->deleteJson(route('customer.cart.remove', $cartItem->id));

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }

    public function test_guest_cannot_add_to_cart(): void
    {
        $menuItem = $this->createMenuItem();

        $response = $this->postJson(route('customer.cart.add'), [
            'menu_item_id' => $menuItem->id,
            'quantity' => 1,
        ]);

        $response->assertUnauthorized();
    }
}
