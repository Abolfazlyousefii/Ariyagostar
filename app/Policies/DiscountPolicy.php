<?php

namespace App\Policies;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('discounts.index');
    }

    public function create(User $user)
    {
        return $user->can('discounts.create');
    }

    public function update(User $user, Discount $discount)
    {
        return $user->can('discounts.update');
    }

    public function delete(User $user, Discount $discount)
    {
        return $user->can('discounts.delete');
    }
}
