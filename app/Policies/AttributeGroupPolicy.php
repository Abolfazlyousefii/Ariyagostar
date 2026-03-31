<?php

namespace App\Policies;

use App\Models\AttributeGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributeGroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('attributes.groups.index');
    }

    public function view(User $user, AttributeGroup $attributeGroup)
    {
        return $user->can('attributes.groups.show');
    }

    public function create(User $user)
    {
        return $user->can('attributes.groups.create');
    }

    public function update(User $user, AttributeGroup $attributeGroup)
    {
        return $user->can('attributes.groups.update');
    }

    public function delete(User $user, AttributeGroup $attributeGroup)
    {
        return $user->can('attributes.groups.delete');
    }
}
