<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $guarded = ['id'];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function type()
    {
        if ($this->type == 'within_province') {
            return 'درون استانی';
        }

        return 'برون استانی';
    }
}
