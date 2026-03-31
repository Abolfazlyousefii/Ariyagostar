<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $guarded = ['id'];

    public static function generateCode()
    {
        $numbers = '0123456789';
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        do {
            $randomString = '';

            for ($i = 0; $i < 2; $i++) {
                $index = rand(0, strlen($numbers) - 1);
                $randomString .= $letters[$index];
            }

            for ($i = 0; $i < 3; $i++) {
                $index = rand(0, strlen($numbers) - 1);
                $randomString .= $numbers[$index];
            }

            $code = str_shuffle($randomString);
        } while (User::where('referral_code', $code)->first());

        return $code;
    }

    public function referral()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referralDiscount()
    {
        return $this->belongsTo(Discount::class, 'owner_discount_id');
    }

    public function userDiscount()
    {
        return $this->belongsTo(Discount::class, 'user_discount_id');
    }
}
