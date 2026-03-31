<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('payments.transactions.index');
    }

    public function view(User $user, Transaction $transaction)
    {
        return $user->can('payments.transactions.view');
    }

    public function delete(User $user, Transaction $transaction)
    {
        return $user->can('payments.transactions.delete');
    }
}
