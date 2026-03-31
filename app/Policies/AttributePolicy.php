<?php

namespace App\Policies;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('attributes.index');
    }

    public function create(User $user)
    {
        return $user->can('attributes.create');
    }

    public function update(User $user, Attribute $attribute)
    {
        return $user->can('attributes.update');
    }

    public function delete(User $user, Attribute $attribute)
    {
        return $user->can('attributes.delete');
    }
}
