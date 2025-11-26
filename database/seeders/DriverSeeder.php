<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'name' => 'Driver One',
                'email' => 'driver1@fooddelivery.com',
                'phone' => '+1234567892',
            ],
            [
                'name' => 'Driver Two',
                'email' => 'driver2@fooddelivery.com',
                'phone' => '+1234567893',
            ],
        ];

        foreach ($drivers as $driverData) {
            User::firstOrCreate(
                ['email' => $driverData['email']],
                [
                    'name' => $driverData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'driver',
                    'phone' => $driverData['phone'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Driver users created successfully!');
        $this->command->info('Email: driver1@fooddelivery.com / driver2@fooddelivery.com');
        $this->command->info('Password: password');
    }
}
