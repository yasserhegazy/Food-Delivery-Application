<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create customer user if doesn't exist
        User::firstOrCreate(
            ['email' => 'customer@fooddelivery.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '+1234567891',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Customer user created successfully!');
        $this->command->info('Email: customer@fooddelivery.com');
        $this->command->info('Password: password');
    }
}
