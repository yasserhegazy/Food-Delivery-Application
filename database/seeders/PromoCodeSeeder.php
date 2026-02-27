<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PromoCode::firstOrCreate(
            ['code' => 'WELCOME10'],
            [
                'description' => '10% off for new customers',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'min_order_amount' => 15,
                'max_discount' => 10,
                'is_active' => true,
            ]
        );

        PromoCode::firstOrCreate(
            ['code' => 'SAVE20'],
            [
                'description' => '$20 off orders over $50',
                'discount_type' => 'fixed',
                'discount_value' => 20,
                'min_order_amount' => 50,
                'is_active' => true,
            ]
        );

        PromoCode::firstOrCreate(
            ['code' => 'FREEDEL'],
            [
                'description' => '$5 off to cover delivery fee',
                'discount_type' => 'fixed',
                'discount_value' => 5,
                'min_order_amount' => 20,
                'is_active' => true,
            ]
        );

        PromoCode::firstOrCreate(
            ['code' => 'HALFOFF'],
            [
                'description' => '50% off, up to $25 discount',
                'discount_type' => 'percentage',
                'discount_value' => 50,
                'min_order_amount' => 30,
                'max_discount' => 25,
                'max_uses' => 100,
                'is_active' => true,
            ]
        );

        $this->command->info('Promo codes seeded successfully!');
    }
}
