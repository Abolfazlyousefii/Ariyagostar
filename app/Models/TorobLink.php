<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TorobLink extends Model
{
    protected $guarded = ['id'];

    public function torob()
    {
        return $this->belongsTo(Torob::class);
    }
}
