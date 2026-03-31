<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SizeType extends Model
{
    use SoftDeletes, Languageable;

    protected $guarded = ['id'];

    public function sizes()
    {
        return $this->hasMany(Size::class)->orderBy('ordering');
    }

    public function values()
    {
        return $this->belongsToMany(Size::class, 'size_type_values')
            ->withPivot(['value', 'group', 'ordering'])
            ->withTimestamps()
            ->orderBy('group')
            ->orderBy('ordering');
    }
}
