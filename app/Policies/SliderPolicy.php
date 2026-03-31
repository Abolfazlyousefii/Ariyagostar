<?php

namespace App\Policies;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('sliders.index');
    }

    public function create(User $user)
    {
        return $user->can('sliders.create');
    }

    public function update(User $user, Slider $slider)
    {
        return $user->can('sliders.update');
    }

    public function delete(User $user, Slider $slider)
    {
        return $user->can('sliders.delete');
    }
}
