<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Restaurant;
use App\Policies\AddressPolicy;
use App\Policies\OrderPolicy;
use App\Policies\RestaurantPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
        Restaurant::class => RestaurantPolicy::class,
        Address::class => AddressPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
