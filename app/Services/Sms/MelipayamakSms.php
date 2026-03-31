<?php

namespace App\Services\Sms;

use App\Contracts\SmsContract;
use App\Contracts\SmsNotificationContract;
use Exception;
use Melipayamak\MelipayamakApi;

class MelipayamakSms extends SmsService implements SmsContract, SmsNotificationContract
{
    public function send()
    {
        $method = $this->method();
        $data   = $this->$method();

        $input_data   = $data['input_data'];
        $mobile       = $this->mobile();
        $bodyId       = $data['bodyId'];

        try {
            $username  = option('MELIPAYAMAK_PANEL_USERNAME');
            $password  = option('MELIPAYAMAK_PANEL_PASSWORD');
            $api       = new MelipayamakApi($username, $password);
            $sms       = $api->sms('soap');
            $to        = $mobile;
            $text      = implode(';', $input_data);
            $response  = $sms->sendByBaseNumber($text, $to, $bodyId);

            $message = json_encode($response);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return $message;
    }

    public function verifyCode()
    {
        return [
            'bodyId'       => option('user_verify_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['code']
            ],
        ];
    }

    public function userCreated()
    {
        return [
            'bodyId'       => option('user_register_pattern_code_melipayamak'),
            'input_data'   => [
                '0'   => $this->data['fullname'],
                '1'   => $this->data['username'],
            ],
        ];
    }

    public function orderPaid()
    {
        return [
            'bodyId'       => option('order_paid_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['order_id']
            ],
        ];
    }

    public function orderDetail()
    {
        return [
            'bodyId'       => option('order_detail_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['order_id'],
                '1' => $this->data['items'],
                '2' => $this->data['order_price'],
            ],
        ];
    }

    public function trackingCode()
    {
        return [
            'bodyId'       => option('tracking_code_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['tracking_code'],
                '1' => $this->data['order_id'],
            ],
        ];
    }

    public function userOrderPaid()
    {
        return [
            'bodyId'       => option('user_order_paid_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['order_id']
            ],
        ];
    }

    public function inPersonOrder()
    {
        return [
            'bodyId'       => option('in_person_order_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['fullname']
            ],
        ];
    }

    public function walletAmountDecreased()
    {
        return [
            'bodyId'       => option('wallet_decrease_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['amount']
            ],
        ];
    }

    public function walletAmountIncreased()
    {
        return [
            'bodyId'       => option('wallet_increase_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['amount']
            ],
        ];
    }

    public function stockAmountIncreased()
    {
        return [
            'bodyId'       => option('stock_increase_pattern_code_melipayamak'),
            'input_data' => [
                0 => $this->data['product_title'],
            ],
        ];
    }
}
