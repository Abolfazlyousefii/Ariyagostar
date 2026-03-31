<?php

namespace App\Services\Sms;

use App\Contracts\SmsContract;
use App\Contracts\SmsNotificationContract;
use Exception;
use Illuminate\Support\Facades\Log;

class IppanelSms extends SmsService implements SmsContract, SmsNotificationContract
{
    public function send()
    {
        $method = $this->method();
        $data   = $this->$method();

        $username      = option('SMS_PANEL_USERNAME');
        $password      = option('SMS_PANEL_PASSWORD');
        $from          = option('SMS_PANEL_FROM');
        $to            = array($this->mobile());
        $pattern_code  = $data['pattern_code'];
        $input_data    = $data['input_data'];

        $url      = "https://ippanel.com/patterns/pattern?username="
            . $username . "&password=" . urlencode($password)
            . "&from=$from&to=" . json_encode($to)
            . "&input_data=" . urlencode(json_encode($input_data))
            . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);

        return $response;
    }

    public function verifyCode()
    {
        return [
            'pattern_code' => option('user_verify_pattern_code'),
            'input_data'   => [
                'code' => $this->data['code']
            ],
        ];
    }

    public function userCreated()
    {
        return [
            'pattern_code' => option('user_register_pattern_code'),
            'input_data'   => [
                'fullname' => $this->data['fullname']
            ],
        ];
    }

    public function orderPaid()
    {
        return [
            'pattern_code' => option('order_paid_pattern_code'),
            'input_data'   => [
                'order_id' => $this->data['order_id']
            ],
        ];
    }

    public function orderDetail()
    {
        return [
            'pattern_code' => option('order_detail_pattern_code'),
            'input_data'   => [
                'order_id'    => $this->data['order_id'],
                'items'       => $this->data['items'],
                'order_price' => $this->data['order_price'],
            ],
        ];
    }

    public function trackingCode()
    {
        return [
            'pattern_code' => option('tracking_code_pattern_code'),
            'input_data'   => [
                'order_id' => $this->data['order_id'],
                'tracking_code' => $this->data['tracking_code']
            ],
        ];
    }

    public function userOrderPaid()
    {
        return [
            'pattern_code' => option('user_order_paid_pattern_code'),
            'input_data'   => [
                'order_id' => $this->data['order_id']
            ],
        ];
    }

    public function inPersonOrder()
    {
        return [
            'pattern_code' => option('in_person_order_pattern_code'),
            'input_data'   => [
                'fullname' => $this->data['fullname']
            ],
        ];
    }

    public function walletAmountDecreased()
    {
        return [
            'pattern_code' => option('wallet_decrease_pattern_code_ippanel'),
            'input_data'   => [
                'amount' => $this->data['amount']
            ],
        ];
    }

    public function walletAmountIncreased()
    {
        return [
            'pattern_code' => option('wallet_increase_pattern_code_ippanel'),
            'input_data'   => [
                'amount' => $this->data['amount']
            ],
        ];
    }

    // other methods
    public static function getCredit()
    {
        $username      = option('SMS_PANEL_USERNAME');
        $password      = option('SMS_PANEL_PASSWORD');

        $url = "https://ippanel.com/services.jspd";
        $param = array(
            'uname' => $username,
            'pass'  => $password,
            'op'    => 'credit'
        );

        if ($username && $password) {
            try {
                $handler = curl_init($url);
                curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                $response2 = curl_exec($handler);

                $response2 = json_decode($response2);
                $res_code = $response2[0];
                $res_data = $response2[1];

                if ($res_code == 0) return $res_data;
            } catch (Exception $e) {
                Log::error($e);
            }
        }

        return 0;
    }

    public function stockAmountIncreased()
    {
        return [
            'pattern_code' => option('stock_amount_pattern_code_ippanel'),
            'input_data'   => [
                'product_title' => $this->data['product_title'],
            ]
        ];
    }
}
