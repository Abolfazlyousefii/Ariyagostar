<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function get_price()
    {
        return $this->belongsTo(Price::class, 'price_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function realPrice()
    {
        return $this->real_price;
    }

    public function discountAmount()
    {
        return $this->quantity * ($this->real_price - $this->price);
    }
}
