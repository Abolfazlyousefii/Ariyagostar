<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('products.index');
    }

    public function create(User $user)
    {
        return $user->can('products.create');
    }

    public function update(User $user, Product $product)
    {
        return $user->can('products.update');
    }

    public function delete(User $user, Product $product)
    {
        return $user->can('products.delete');
    }
}
