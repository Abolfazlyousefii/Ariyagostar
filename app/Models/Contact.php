<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use Languageable;

    protected $guarded = ['id'];
}
