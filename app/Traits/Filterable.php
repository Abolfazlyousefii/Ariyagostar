<?php

namespace App\Traits;

use App\Models\Filter;

trait Filterable
{
    public function filters()
    {
        return $this->morphToMany(Filter::class, 'filterable')
            ->withPivot('active', 'ordering', 'separator')
            ->withTimestamps();
    }
}
