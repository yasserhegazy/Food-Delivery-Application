<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id
            || $user->id === $order->driver_id
            || $user->id === $order->restaurant?->user_id
            || $user->isAdmin();
    }

    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->restaurant?->user_id
            || $user->id === $order->driver_id;
    }

    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->user_id
            && $order->status === 'pending';
    }
}
