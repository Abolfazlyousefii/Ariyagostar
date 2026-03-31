<?php

namespace App\Notifications\Sms;

use App\Models\Sms;
use App\Models\Order;
use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TrackingCodeSms extends Notification
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
                'order_id' => $this->order->id,
                'tracking_code' => $this->order->tracking_code,
            ],
            'type'    => Sms::TYPES['TRACKING_CODE'],
            'user_id' => $notifiable->id
        ];
    }
}
