<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes, Languageable;

    protected $guarded = ['id'];

    public function amount()
    {
        return $this->amount;
    }

    public function prices()
    {
        return $this->hasManyThrough(Price::class, Product::class)->withTrashed();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
