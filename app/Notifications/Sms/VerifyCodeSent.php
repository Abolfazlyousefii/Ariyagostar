<?php

namespace App\Notifications\Sms;

use App\Channels\SmsChannel;
use App\Models\OneTimeCode;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyCodeSent extends Notification
{
    use Queueable;

    protected $verify_code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        OneTimeCode::where('user_id', $user->id)->delete();

        $code = OneTimeCode::create([
            'user_id' => $user->id,
            'code'    => rand(11111, 99999),
        ]);

        $this->verify_code = $code->code;
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
                'code' => $this->verify_code
            ],
            'type'    => Sms::TYPES['VERIFY_CODE'],
            'user_id' => $notifiable->id
        ];
    }
}
