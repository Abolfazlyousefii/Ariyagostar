<?php

namespace App\Listeners\Wallet;

use App\Events\WalletAmountDecreased;
use App\Notifications\Wallet\WalletAmountDecreasedSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendWalletDecreasedSms
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\WalletAmountDecreased  $event
     * @return void
     */
    public function handle(WalletAmountDecreased $event)
    {
        $amount = $event->wallet
            ->histories()
            ->where('type', 'withdraw')
            ->latest()
            ->first();

        Notification::send($event->wallet->user, new WalletAmountDecreasedSms($event->wallet, $amount->amount));
    }
}
