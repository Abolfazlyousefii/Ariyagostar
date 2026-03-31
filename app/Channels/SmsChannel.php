<?php

namespace App\Channels;

use App\Services\Sms\SmsService;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toSms($notifiable);

        $smsService = new SmsService($data['mobile'], $data['data'], $data['type'], $data['user_id']);
        $smsService->sendSms();
    }
}
