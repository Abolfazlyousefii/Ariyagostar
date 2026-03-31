<?php

namespace App\Traits;

use App\Models\Tag;
use App\Observers\TaggableObserver;

trait Taggable
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getGetTagsAttribute()
    {
        return implode(',', $this->tags()->pluck('name')->toArray());
    }

    public static function bootTaggable()
    {
        static::observe(app(TaggableObserver::class));
    }
}
