<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrier extends Model
{
    use SoftDeletes, Languageable;

    protected $guarded = ['id'];

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where(function ($q) {
            $q->where('carrige_forward', true)->orWhereHas('tariffs');
        });
    }

    public function getCityTarif($city_id, $weight)
    {
        $is_within_province = $this->province->cities()->find($city_id);

        if ($is_within_province) {
            $tariff = $this->tariffs()
                ->where('type', 'within_province')
                ->where('max_weight', '>=', $weight)
                ->orderBy('max_weight')
                ->first();

            if (!$tariff && $this->extra_cost) {
                $tariff = $this->tariffs()
                    ->where('type', 'within_province')
                    ->orderBy('max_weight')
                    ->first();
            }
        } else {
            $tariff = $this->tariffs()
                ->where('type', 'extra_province')
                ->where('max_weight', '>=', $weight)
                ->orderBy('max_weight')
                ->first();

            if (!$tariff && $this->extra_cost) {
                $tariff = $this->tariffs()
                    ->where('type', 'extra_province')
                    ->orderBy('max_weight')
                    ->first();
            }
        }

        return $tariff;
    }
}
