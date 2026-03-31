<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filterable extends Model
{
    protected $guarded = ['id'];

    public function filterable()
    {
        return $this->morphTo();
    }
}
