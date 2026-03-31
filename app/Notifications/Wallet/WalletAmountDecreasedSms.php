<?php

namespace App\Notifications\Wallet;

use App\Channels\SmsChannel;
use App\Models\Sms;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class WalletAmountDecreasedSms extends Notification implements ShouldQueue
{
    use Queueable;

    public $wallet;
    public $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Wallet $wallet, $amount)
    {
        $this->wallet = $wallet;
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return [
            'mobile'       => $notifiable->username,
            'data'         => [
                'wallet'   => $this->wallet,
                'amount'   => $this->amount,
            ],
            'type'         => Sms::TYPES['WALLET_AMOUNT_DECREASED'],
            'user_id'      => $notifiable->id
        ];
    }
}
