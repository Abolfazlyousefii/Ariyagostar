<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;

class SpecificationGroup extends Model
{
    use Languageable;

    protected $guarded = ['id'];

    public function specifications()
    {
        return $this->belongsToMany(Specification::class);
    }
}
