<?php

namespace App\Listeners\User;

use App\Events\WalletAmountIncreased;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class AddGiftCredit
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $gift_credit = intval(option('user_register_gift_credit', 0));

        if ($gift_credit > 0) {
            $user = $event->user;

            $wallet = $user->getWallet();

            DB::transaction(function () use ($wallet, $gift_credit) {
                $wallet->histories()->create([
                    'type'        => 'deposit',
                    'amount'      => $gift_credit,
                    'status'      => 'success',
                    'description' => 'اعتبار هدیه'
                ]);

                $wallet->update([
                    'balance' => $wallet->balance + $gift_credit
                ]);
            });

            event(new WalletAmountIncreased($wallet));
        }
    }
}
