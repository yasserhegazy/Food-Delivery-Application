<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;

class RestaurantPolicy
{
    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id
            || $user->isAdmin();
    }

    public function manageMenu(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id;
    }

    public function viewOrders(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id
            || $user->isAdmin();
    }
}
