<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Widget;
use Illuminate\Auth\Access\HandlesAuthorization;

class WidgetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('themes.widgets');
    }

    public function create(User $user)
    {
        return $user->can('themes.widgets');
    }

    public function update(User $user, Widget $widget)
    {
        return $user->can('themes.widgets');
    }

    public function delete(User $user, Widget $widget)
    {
        return $user->can('themes.widgets');
    }
}
