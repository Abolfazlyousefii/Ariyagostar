<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(WalletHistory::class, 'wallet_id');
    }

    public function balance()
    {
        return $this->histories()->where('status', 'success')->where('type', 'deposit')->sum('amount') - $this->histories()->where('status', 'success')->where('type', 'withdraw')->sum('amount');
    }

    public function refereshBalance()
    {
        $this->balance = $this->balance();
        $this->save();
    }
}
