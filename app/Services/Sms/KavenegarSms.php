<?php

namespace App\Services\Sms;

use App\Contracts\SmsContract;
use App\Contracts\SmsNotificationContract;
use Illuminate\Support\Facades\Config;
use Kavenegar;

class KavenegarSms extends SmsService implements SmsContract, SmsNotificationContract
{
    public function send()
    {
        $method = $this->method();
        $data   = $this->$method();

        $input_data   = $data['input_data'];
        $mobile       = $this->mobile();
        $template     = $data['template'];

        Config::set('kavenegar.apikey', option('KAVENEGAR_PANEL_APIKEY'));

        try {
            $token   = $input_data['token'] ?? null;
            $token2  = $input_data['token2'] ?? null;
            $token3  = $input_data['token3'] ?? null;
            $token10 = $input_data['token10'] ?? null;
            $token20 = $input_data['token20'] ?? null;

            $result = Kavenegar::VerifyLookup($mobile, $token, $token2, $token3, $template, $type = null, $token10, $token20);

            $response = json_encode($result);
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            $response = $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            $response = $e->errorMessage();
        }

        return $response;
    }

    public function verifyCode()
    {
        return [
            'template'     => option('user_verify_pattern_code_kavenegar'),
            'input_data'   => [
                'token' => $this->data['code']
            ],
        ];
    }

    public function userCreated()
    {
        return [
            'template'     => option('user_register_pattern_code_kavenegar'),
            'input_data'   => [
                'token20' => $this->data['fullname'],
                'token'   => $this->data['username'],
            ],
        ];
    }

    public function orderPaid()
    {
        return [
            'template'     => option('order_paid_pattern_code_kavenegar'),
            'input_data'   => [
                'token' => $this->data['order_id']
            ],
        ];
    }

    public function orderDetail()
    {
        return [
            'template'     => option('order_detail_pattern_code_kavenegar'),
            'input_data'   => [
                'token'   => $this->data['order_id'],
                'token20' => $this->data['items'],
                'token2'  => $this->data['order_price'],
            ],
        ];
    }

    public function trackingCode()
    {
        return [
            'template'     => option('tracking_code_pattern_code_kavenegar'),
            'input_data'   => [
                'token' => $this->data['order_id'],
                'token20' => $this->data['tracking_code'],
            ],
        ];
    }

    public function userOrderPaid()
    {
        return [
            'template'     => option('user_order_paid_pattern_code_kavenegar'),
            'input_data'   => [
                'token' => $this->data['order_id']
            ],
        ];
    }

    public function inPersonOrder()
    {
        return [
            'template'     => option('in_person_order_pattern_code_kavenegar'),
            'input_data'   => [
                'token'   => $this->data['order_id'],
                'token20' => $this->data['fullname']
            ],
        ];
    }

    public function walletAmountDecreased()
    {
        return [
            'template'     => option('wallet_decrease_pattern_code_kavenegar'),
            'input_data'   => [
                'token'    => $this->data['amount']
            ],
        ];
    }

    public function walletAmountIncreased()
    {
        return [
            'template'     => option('wallet_increase_pattern_code_kavenegar'),
            'input_data'   => [
                'token'    => $this->data['amount']
            ],
        ];
    }


    public function stockAmountIncreased()
    {
        return[
            'template'     => option('stock_amount_pattern_code_kavenegar'),
            'input_data'   => [
                'token'   => $this->data['product_id'],
                'token20'   => $this->data['product_title'],
            ],
        ];
    }
}
