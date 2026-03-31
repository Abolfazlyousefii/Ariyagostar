<?php

namespace App\Traits;

trait Languageable
{
    public function scopeDetectLang($query)
    {
        return $query->where('lang', app()->getLocale());
    }
}
