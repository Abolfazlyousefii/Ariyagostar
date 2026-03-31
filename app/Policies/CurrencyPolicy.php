<?php

namespace App\Policies;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurrencyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('payments.currencies');
    }

    public function create(User $user)
    {
        return $user->can('payments.currencies');
    }

    public function update(User $user, Currency $currency)
    {
        return $user->can('payments.currencies');
    }

    public function delete(User $user, Currency $currency)
    {
        return $user->can('payments.currencies');
    }
}
