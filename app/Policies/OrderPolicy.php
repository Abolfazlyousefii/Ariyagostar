<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('orders.index');
    }

    public function view(User $user, Order $order)
    {
        return $user->can('orders.view');
    }

    public function create(User $user)
    {
        return $user->can('orders.create');
    }

    public function update(User $user, Order $order)
    {
        return $user->can('orders.update');
    }

    public function delete(User $user, Order $order)
    {
        return $user->can('orders.delete');
    }
}
