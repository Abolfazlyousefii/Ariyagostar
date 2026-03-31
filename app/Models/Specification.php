<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function group()
    {
        return $this->belongsToMany(SpecificationGroup::class);
    }
}
