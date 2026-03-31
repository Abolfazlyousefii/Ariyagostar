<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceChange extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
