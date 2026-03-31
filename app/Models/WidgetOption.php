<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetOption extends Model
{
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function hasCategory()
    {
        return $this->value == 'on';
    }
}
