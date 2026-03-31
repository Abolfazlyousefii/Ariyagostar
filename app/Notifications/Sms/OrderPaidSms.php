<?php

namespace App\Notifications\Sms;

use App\Channels\SmsChannel;
use App\Models\Order;
use App\Models\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaidSms extends Notification implements ShouldQueue
{
    use Queueable;
    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
            'mobile'  => $notifiable->username,
            'data'    => [
                'order_id' => $this->order->id
            ],
            'type'    => Sms::TYPES['USER_ORDER_PAID'],
            'user_id' => $notifiable->id
        ];
    }
}
