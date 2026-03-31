<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;

class StaticFilter extends Model
{
    use Filterable, Languageable;

    protected $guarded = ['id'];
}
