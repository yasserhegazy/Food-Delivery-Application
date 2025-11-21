<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'View Orders', 'slug' => 'view-orders', 'description' => 'Can view orders'],
            ['name' => 'Create Orders', 'slug' => 'create-orders', 'description' => 'Can create new orders'],
            ['name' => 'Manage Menu', 'slug' => 'manage-menu', 'description' => 'Can manage restaurant menu'],
            ['name' => 'Manage Restaurant', 'slug' => 'manage-restaurant', 'description' => 'Can manage restaurant details'],
            ['name' => 'Accept Deliveries', 'slug' => 'accept-deliveries', 'description' => 'Can accept delivery requests'],
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'description' => 'Can manage platform users'],
            ['name' => 'View Analytics', 'slug' => 'view-analytics', 'description' => 'Can view analytics and reports'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'description' => 'Can manage platform settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create roles
        $customerRole = Role::create([
            'name' => 'Customer',
            'slug' => 'customer',
            'description' => 'Regular customer who orders food',
        ]);

        $restaurantRole = Role::create([
            'name' => 'Restaurant Owner',
            'slug' => 'restaurant_owner',
            'description' => 'Restaurant owner who manages menu and orders',
        ]);

        $driverRole = Role::create([
            'name' => 'Delivery Driver',
            'slug' => 'driver',
            'description' => 'Delivery driver who delivers orders',
        ]);

        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Platform administrator with full access',
        ]);

        // Assign permissions to roles
        $customerRole->permissions()->attach(
            Permission::whereIn('slug', ['view-orders', 'create-orders'])->pluck('id')
        );

        $restaurantRole->permissions()->attach(
            Permission::whereIn('slug', ['view-orders', 'manage-menu', 'manage-restaurant', 'view-analytics'])->pluck('id')
        );

        $driverRole->permissions()->attach(
            Permission::whereIn('slug', ['view-orders', 'accept-deliveries'])->pluck('id')
        );

        $adminRole->permissions()->attach(
            Permission::all()->pluck('id')
        );
    }
}

