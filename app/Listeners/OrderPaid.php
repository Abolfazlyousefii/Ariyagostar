<?php

namespace App\Listeners;

use App\Events\OrderPaid as EventsOrderPaid;
use App\Models\Sms;
use App\Models\User;
use App\Notifications\Order\OrderPaid as NotificationsOrderPaid;
use App\Notifications\Sms\OrderPaidSms;
use App\Notifications\Sms\ProductChargedInformSms;
use App\Services\Sms\SmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class OrderPaid
{
    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(EventsOrderPaid $event)
    {
        $order = $event->order;

        foreach ($order->items()->get() as $item) {
            if ($item->product) {
                $sell = $item->product->sell + $item->quantity;

                $item->product()->update([
                    'sell' => $sell
                ]);
            }
        }

        $admins = User::whereIn('level', ['admin', 'creator'])->get();
        Notification::send($admins, new NotificationsOrderPaid($order));

        if (option('sms_on_order_paid', 'off') == 'on') {
            foreach (explode(',', option('admin_mobile_number')) as $mobile) {
                $smsService = new SmsService(
                    $mobile,
                    [
                        'order_id' => $order->id
                    ],
                    Sms::TYPES['ORDER_PAID'],
                    null
                );

                $smsService->sendSms();
            }
        }

        if (option('detail_sms_on_order_paid', 'off') == 'on') {
            foreach (explode(',', option('admin_mobile_number')) as $mobile) {

                $items_string = '';
                $count = 1;

                foreach ($order->items()->get() as $item) {
                    $items_string .= $count . '- ' . $item->title;

                    if ($item->get_price && $item->get_price->getAttributesName()) {
                        $items_string .= ' (' . $item->get_price->getAttributesName() . ')';
                    }

                    $items_string .= PHP_EOL;

                    $count++;
                }

                // $items_string = truncateText($items_string);

                $smsService = new SmsService(
                    $mobile,
                    [
                        'order_id'    => $order->id,
                        'items'       => $items_string,
                        'order_price' => number_format($order->price)
                    ],
                    Sms::TYPES['ORDER_DETAIL'],
                    null
                );

                $smsService->sendSms();
            }
        }

        if (option('user_sms_on_order_paid', 'off') == 'on') {
            Notification::send($order->user, new OrderPaidSms($order));
        }
    }
}
