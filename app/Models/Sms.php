<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $guarded = ['id'];

    const TYPES = [
        'VERIFY_CODE' => [
            'key'    => 'verify-code',
            'string' => 'کد تایید',
            'method' => 'verifyCode'
        ],
        'USER_CREATED' => [
            'key'    => 'user-created',
            'string' => 'خوش آمدگویی کاربر',
            'method' => 'userCreated'
        ],
        'ORDER_PAID' => [
            'key'    => 'order-paid',
            'string' => 'اطلاع رسانی پرداخت سفارش به مدیر',
            'method' => 'orderPaid'
        ],
        'ORDER_DETAIL' => [
            'key'    => 'order-detail',
            'string' => 'اطلاع رسانی آیتم های سفارش به مدیر',
            'method' => 'orderDetail'
        ],
        'TRACKING_CODE' => [
            'key'    => 'tracking-code',
            'string' => 'اطلاع رسانی ثبت کد پیگیری سفارش',
            'method' => 'trackingCode'
        ],
        'USER_ORDER_PAID' => [
            'key'    => 'user-order-paid',
            'string' => 'اطلاع رسانی پرداخت سفارش به کاربر',
            'method' => 'userOrderPaid'
        ],
        'IN_PERSON_ORDER' => [
            'key'    => 'in-person-order',
            'string' => 'اطلاع رسانی سفارش حضوری',
            'method' => 'inPersonOrder'
        ],
        'WALLET_AMOUNT_DECREASED' => [
            'key'    => 'wallet-amount-decreased',
            'string' => 'اطلاع رسانی کاهش موجودی کیف پول',
            'method' => 'walletAmountDecreased'
        ],
        'WALLET_AMOUNT_INCREASED' => [
            'key'    => 'wallet-amount-decreased',
            'string' => 'اطلاع رسانی افزایش موجودی کیف پول',
            'method' => 'walletAmountIncreased'
        ],
        'STOCK_AMOUNT_INCREASED' => [
            'key'    => 'stock-amount-increased',
            'string' => 'اطلاع رسانی افزایش موجودی کالا',
            'method' => 'stockAmountIncreased'
        ],

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        foreach (self::TYPES as $type) {
            if ($this->type == $type['key']) {
                return $type['string'];
            }
        }
    }
}
