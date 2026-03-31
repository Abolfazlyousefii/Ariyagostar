<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes, Languageable;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilter($query, $request)
    {
        if ($name = $request->input('query.name')) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($city_name = $request->input('query.city_name')) {
            $query->whereHas('cities', function ($q) use ($city_name) {
                $q->where('name', 'like', '%' . $city_name . '%');
            });
        }

        $is_active = $request->input('query.is_active');

        if ($is_active !== null) {
            $query->where('is_active', $is_active);
        }

        if ($request->sort) {
            switch ($request->sort['field']) {
                case 'cities_count': {
                        $query->withCount('cities')->orderBy('cities_count', $request->sort['sort']);
                        break;
                    }
                default: {
                        if ($this->getConnection()->getSchemaBuilder()->hasColumn($this->getTable(), $request->sort['field'])) {
                            $query->orderBy($request->sort['field'], $request->sort['sort']);
                        }
                    }
            }
        }

        return $query;
    }
}
