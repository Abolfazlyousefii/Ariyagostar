<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $guarded = ['id'];

    public function galleryable()
    {
        return $this->morphTo();
    }
}
