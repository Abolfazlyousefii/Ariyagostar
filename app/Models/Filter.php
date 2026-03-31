<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use Languageable;

    protected $guarded = ['id'];

    public function related()
    {
        return $this->hasMany(Filterable::class);
    }

    public function filterable()
    {
        return $this->morphTo();
    }
}
