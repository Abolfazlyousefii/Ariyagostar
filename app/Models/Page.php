<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Taggable;
use App\Traits\Languageable;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model implements Sitemapable
{
    use sluggable, Taggable, Languageable;

    protected $guarded = ['id'];

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route("front.pages.show", ["page" => $this]))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'slug',
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function link()
    {
        return route('front.pages.show', ['page' => $this], false);
    }
}
