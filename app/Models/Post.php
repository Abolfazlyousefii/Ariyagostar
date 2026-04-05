<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Taggable;
use Illuminate\Support\Str;
use App\Traits\Languageable;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model implements Sitemapable
{
    use sluggable, Taggable, Languageable;

    protected $guarded = ['id'];

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route("front.blog.show", $this))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }

    public function sluggable(): array
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getShortContentAttribute()
    {
        $content = strip_tags($this->content);

        return Str::words($content, 15);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function link()
    {
        return route('front.blog.show', ['post' => $this]);
    }

    public function scopePublished($query)
    {
        $query->where('published', true)->where(function ($q) {
            $q->where('publish_date', null)->orWhere('publish_date', '<=', Carbon::now());
        });

        return $query;
    }

    public function scopeUnpublished($query)
    {
        return $query->where(function ($q) {
            $q->where('published', false)->orWhere(function ($q2) {
                $q2->where('publish_date', '>', Carbon::now());
            });
        });
    }

    public function isPublished()
    {
        return ($this->published && (!$this->publish_date || $this->publish_date <= Carbon::now()));
    }

    public function isShowable()
    {
        if ($this->isPublished()) {
            return true;
        }

        if (auth()->check() && auth()->user()->can('posts')) {
            return true;
        }

        return false;
    }

    public function scopeFilter($query)
    {
        $request = request();

        $categories = $request->input('category_id');

        if ($categories) {

            $allcats = $categories;
            $no_category = false;

            foreach ($categories as $key => $category) {

                if ($category == 'no_category') {
                    unset($allcats[$key]);
                    $no_category = true;
                    continue;
                }

                $category = Category::find($category);

                if ($category) {
                    $allcats = array_merge($category->allChildCategories(), $allcats);
                }
            }

            if ($no_category) {
                $query->where(function ($q) use ($allcats) {
                    $q->whereIn('category_id', $allcats)->orWhereNull('category_id');
                });
            } else {
                $query->whereIn('category_id', $allcats);
            }
        }

        if ($published = $request->input('published')) {
            switch ($published) {
                case "yes": {
                    $query->published();
                    break;
                }
                case "no": {
                    $query->unpublished();
                    break;
                }
            }
        }

        switch ($request->input('sort')) {
            case "view": {
                $query->orderBy('view', 'desc');
                break;
            }
            case "oldest": {
                $query->oldest();
                break;
            }
            default: {
                $query->latest();
            }
        }


        if ($request->title) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->title . '%');
            });
        }

        return $query;
    }

    public function scopeApiFilter($query)
    {
        $request = request();

        if ($category_id = $request->category_id) {
            $category = Category::findOrFail($category_id);

            if ($category) {
                $query->whereIn('category_id', $category->allChildCategories());
            }
        }

        if ($request->search && is_string($request->search)) {
            $query->where(function ($query2) use ($request) {
                $query2->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $sort_type = in_array($request->sort_type, ['asc', 'desc']) ? $request->sort_type : 'asc';

        switch ($request->sort_field) {
            case "view": {
                $query->orderBy('view', $sort_type);
                break;
            }
            default: {
                $query->latest();
            }
        }

        return $query;
    }
}
