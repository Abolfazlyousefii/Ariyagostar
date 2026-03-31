<?php

namespace App\Notifications\Sms;

use App\Channels\SmsChannel;
use App\Models\Product;
use App\Models\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ProductChargedInformSms extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;


    /**
     * Create a new notification instance.
     *
     * @param  array|string  $mobiles
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
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

    /**
     * Get the SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toSms($notifiable)
    {
        return [
            'mobile' => $notifiable, // استفاده از شماره موبایل از notifiable
            'data' => [
                'product_id' => $this->product->id,
                'product_title' => $this->product->title,
            ],
            'type' => Sms::TYPES['STOCK_AMOUNT_INCREASED'],
            'user_id' => $notifiable->id ?? null,
        ];
    }
}
