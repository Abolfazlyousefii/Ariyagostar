<?php

namespace App\Services\Sms;

use App\Contracts\SmsContract;
use App\Contracts\SmsNotificationContract;

class IdehPardazanSms extends SmsService implements SmsContract, SmsNotificationContract
{
    public function send()
    {
        $method = $this->method();
        $data = $this->$method();

        $body = [
            'mobile' => $this->mobile,
            'UserApiKey' => option('IDEHPARDAZAN_PANEL_APIKEY'),
            'SecretKey' => option('IDEHPARDAZAN_PANEL_SECRET_KEY')
        ];

        $body = array_merge($data, $body);
        $body = json_encode($body, true);

        $url = "https://RestfulSms.com/api/UltraFastSend/direct";
        $headers = array(
            'Content-Type: application/json',
        );
        $handler = curl_init($url);

        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $body);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);

        return $response;
    }

    public function verifyCode()
    {
        return [
            'TemplateId' => option('user_verify_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "code",
                    "ParameterValue" => $this->data['code']
                ]
            ],
        ];
    }

    public function userCreated()
    {
        return [
            'TemplateId' => option('user_register_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "fullname",
                    "ParameterValue" => $this->data['fullname']
                ]
            ],
        ];
    }

    public function orderPaid()
    {
        return [
            'TemplateId' => option('order_paid_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "order_id",
                    "ParameterValue" => $this->data['order_id']
                ]
            ],
        ];
    }

    public function orderDetail()
    {
        return [
            'TemplateId' => option('order_paid_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "order_id",
                    "ParameterValue" => $this->data['order_id']
                ],
                [
                    "Parameter" => "items",
                    "ParameterValue" => $this->data['items']
                ],
                [
                    "Parameter" => "order_price",
                    "ParameterValue" => $this->data['order_price']
                ],
            ],
        ];
    }

    public function trackingCode()
    {
        return [
            'TemplateId' => option('tracking_code_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "order_id",
                    "ParameterValue" => $this->data['order_id']
                ],
                [
                    "Parameter" => "tracking_code",
                    "ParameterValue" => $this->data['tracking_code']
                ]
            ],
        ];
    }

    public function userOrderPaid()
    {
        return [
            'TemplateId' => option('user_order_paid_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "order_id",
                    "ParameterValue" => $this->data['order_id']
                ]
            ],
        ];
    }

    public function inPersonOrder()
    {
        return [
            'TemplateId' => option('in_person_order_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "fullname",
                    "ParameterValue" => $this->data['fullname']
                ]
            ],
        ];
    }

    public function walletAmountDecreased()
    {
        return [
            'TemplateId' => option('wallet_decrease_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "amount",
                    "ParameterValue" => $this->data['amount']
                ]
            ],
        ];
    }

    public function walletAmountIncreased()
    {
        return [
            'TemplateId' => option('wallet_increase_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "amount",
                    "ParameterValue" => $this->data['amount']
                ]
            ],
        ];
    }

    public function stockAmountIncreased()
    {
        return [
            'TemplateId' => option
            ('stock_increase_pattern_code_idehpardazan'),
            'ParameterArray' => [
                [
                    "Parameter" => "product_title",
                    "ParameterValue" => $this->data['product_title']
                ],
            ],
        ];
    }
}
