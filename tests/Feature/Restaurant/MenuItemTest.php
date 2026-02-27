<?php

namespace Tests\Feature\Restaurant;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemTest extends TestCase
{
    use RefreshDatabase;

    private function createOwnerWithRestaurant(): array
    {
        $owner = User::factory()->create(['role' => 'restaurant_owner']);
        $restaurant = Restaurant::factory()->create(['user_id' => $owner->id]);
        $category = Category::factory()->create(['restaurant_id' => $restaurant->id]);

        return compact('owner', 'restaurant', 'category');
    }

    public function test_restaurant_owner_can_view_menu(): void
    {
        $data = $this->createOwnerWithRestaurant();
        MenuItem::factory()->create(['category_id' => $data['category']->id]);

        $response = $this->actingAs($data['owner'])->get(route('restaurant.menu.index'));

        $response->assertStatus(200);
    }

    public function test_restaurant_owner_can_create_menu_item(): void
    {
        $data = $this->createOwnerWithRestaurant();

        $response = $this->actingAs($data['owner'])->post(route('restaurant.menu.store'), [
            'category_id' => $data['category']->id,
            'name' => 'Test Burger',
            'description' => 'A delicious test burger',
            'price' => 12.99,
            'is_available' => true,
            'is_featured' => false,
        ]);

        $response->assertRedirect(route('restaurant.menu.index'));
        $this->assertDatabaseHas('menu_items', [
            'name' => 'Test Burger',
            'category_id' => $data['category']->id,
        ]);
    }

    public function test_restaurant_owner_can_update_menu_item(): void
    {
        $data = $this->createOwnerWithRestaurant();
        $menuItem = MenuItem::factory()->create(['category_id' => $data['category']->id]);

        $response = $this->actingAs($data['owner'])->put(route('restaurant.menu.update', $menuItem), [
            'category_id' => $data['category']->id,
            'name' => 'Updated Burger',
            'description' => 'Updated description',
            'price' => 14.99,
            'is_available' => true,
            'is_featured' => false,
        ]);

        $response->assertRedirect(route('restaurant.menu.index'));
        $this->assertDatabaseHas('menu_items', [
            'id' => $menuItem->id,
            'name' => 'Updated Burger',
        ]);
    }

    public function test_restaurant_owner_can_toggle_menu_item_availability(): void
    {
        $data = $this->createOwnerWithRestaurant();
        $menuItem = MenuItem::factory()->create([
            'category_id' => $data['category']->id,
            'is_available' => true,
        ]);

        $response = $this->actingAs($data['owner'])->postJson(route('restaurant.menu.toggle', $menuItem));

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'is_available' => false]);

        $this->assertDatabaseHas('menu_items', [
            'id' => $menuItem->id,
            'is_available' => false,
        ]);
    }

    public function test_non_owner_cannot_manage_menu_items(): void
    {
        $data = $this->createOwnerWithRestaurant();
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get(route('restaurant.menu.index'));

        $response->assertStatus(403);
    }
}
