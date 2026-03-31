<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('menus.index');
    }
    public function view(User $user, Menu $menu)
    {
        return $user->can('menus.update');
    }

    public function create(User $user)
    {
        return $user->can('menus.create');
    }

    public function update(User $user, Menu $menu)
    {
        return $user->can('menus.update');
    }

    public function delete(User $user, Menu $menu)
    {
        return $user->can('menus.delete');
    }
}
