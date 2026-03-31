<?php

namespace App\Listeners\Wallet;

use App\Events\WalletAmountIncreased;
use App\Notifications\Wallet\WalletAmountIncreasedSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendWalletIncreasedSms
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\WalletAmountIncreased  $event
     * @return void
     */
    public function handle(WalletAmountIncreased $event)
    {
        $amount = $event->wallet
            ->histories()
            ->where('type', 'deposit')
            ->latest()
            ->first();

        Notification::send($event->wallet->user, new WalletAmountIncreasedSms($event->wallet, $amount->amount));
    }
}
