<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $guarded = ['id'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function type()
    {
        if ($this->type == 'deposit') {
            return 'افزایش اعتبار';
        }

        return 'برداشت';
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
