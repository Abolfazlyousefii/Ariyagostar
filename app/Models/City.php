<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes, Languageable;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
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

        $is_active = $request->input('query.is_active');

        if ($is_active !== null) {
            $query->where('is_active', $is_active);
        }

        if ($request->sort) {
            switch ($request->sort['field']) {
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
