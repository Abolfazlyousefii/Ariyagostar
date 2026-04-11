<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Taggable;
use App\Traits\Languageable;
use Spatie\Sitemap\Tags\Url;
use App\Traits\ProductScopes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements Sitemapable
{
    use HasFactory, sluggable, Taggable, ProductScopes, Languageable;

    protected $guarded = ['id'];

    public function toSitemapTag(): Url|string|array
    {
        // Return with fine-grained control:
        return Url::create(route("front.products.show", ['product' => $this]))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug',
            ],
        ];
    }

    //------------- start relations

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function compatibleModels()
    {
        return $this->belongsToMany(CompatibleModel::class)->orderBy('name');
    }

    public function gallery()
    {
        return $this->morphMany(Gallery::class, 'galleryable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function specificationGroups()
    {
        return $this->belongsToMany(SpecificationGroup::class, 'product_specification')->withPivot(['specification_group_id', 'group_ordering', 'specification_ordering', 'value', 'special'])->withTimestamps()->orderBy('group_ordering');
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specification')
            ->withPivot(['specification_group_id', 'group_ordering', 'specification_ordering', 'value', 'special'])
            ->withTimestamps()
            ->orderBy('group_ordering')
            ->orderBy('specification_ordering');
    }

    public function specialSpecifications()
    {
        return $this->specifications()->where('special', true)->get();
    }

    public function specType()
    {
        return $this->belongsTo(SpecType::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function lowestPrice()
    {
        return $this->hasOne(Price::class)
            ->where('stock', '>', 0)
            ->orderByRaw('if((discount_expire_at is null or date(discount_expire_at) > "' . now()->format('Y-m-d H:i:s') . '"), discount_price, regular_price)');
    }

    public function getPrices()
    {
        return $this->hasMany(Price::class)
            ->where('stock', '>', 0)
            ->orderByRaw('if((discount_expire_at is null or date(discount_expire_at) > "' . now()->format('Y-m-d H:i:s') . '"), discount_price, regular_price)');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function priceChanges()
    {
        return $this->hasMany(PriceChange::class);
    }

    public function files()
    {
        return $this->hasManyThrough(File::class, Price::class, 'product_id', 'fileable_id')
            ->where(
                'fileable_type',
                Price::class
            );
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class)->withTrashed();
    }

    public function relatedProducts()
    {
        if ($this->category) {
            return $this->category->allPublishedProducts()->where('id', '!=', $this->id);
        }

        return Product::query()->where('id', '!=', $this->id);
    }

    public function labels()
    {
        return $this->morphToMany(Label::class, 'labelable')->withTimestamps();
    }

    public function torob()
    {
        return $this->hasOne(Torob::class);
    }

    //------------- end relations

    public function getDiscountPriceAttribute()
    {
        if ($this->discount) {
            return $this->price - ($this->price * ($this->discount / 100));
        }

        return $this->price;
    }

    public function getSpecialEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function link()
    {
        return Route::has('front.products.show') ? route('front.products.show', ['product' => $this]) : '#';
    }

    public function isPhysical()
    {
        return $this->type == 'physical';
    }

    public function isDownload()
    {
        return $this->type == 'download';
    }

    public function isSpecial()
    {
        return $this->special && ($this->special_end_date == null || $this->special_end_date->gt(now()));
    }

    public function addableToCart()
    {
        if ($this->type != 'physical') {
            return true;
        }

        if ($this->price_type == "multiple-price" && !$this->prices()->where('stock', '>', 0)->first()) {
            return false;
        }

        return true;
    }

    public function isPublished()
    {
        if ($this->category && !$this->category->isPublished()) {
            return false;
        }

        return ($this->published && (!$this->publish_date || $this->publish_date <= Carbon::now()));
    }

    public function isShowable()
    {
        if ($this->isPublished()) {
            return true;
        }

        if (auth()->check() && auth()->user()->can('products')) {
            return true;
        }

        return false;
    }

    public function isComparable()
    {
        return $this->spec_type_id != null;
    }

    public function isUserFavorite()
    {
        return auth()->check() && auth()->user()->favorites()->where('product_id', $this->id)->first();
    }

    public function shouldShowCompatibleModelsSection()
    {
        $keywords = ['گارد', 'گلس', 'guard', 'glass'];

        $categories = collect([$this->category])
            ->filter()
            ->merge($this->categories)
            ->flatMap(function ($category) {
                return collect([$category])->merge($category->parents());
            })
            ->unique('id');

        return $categories->contains(function ($category) use ($keywords) {
            return Str::contains(Str::lower($category->title . ' ' . $category->slug), $keywords);
        });
    }

    public function getLowestPrice($numeric = false, $major_price = false)
    {
        $price = $this->lowestPrice;

        if ($this->isDownload()) {
            return $numeric ? null : 'محصول دانلودی';
        }

        if ($price && $price->stock) {
            if ($major_price && $price->cart_min > 0 && $price->cart_min == $price->cart_max) {
                return $numeric ? $price->salePrice() * $price->cart_min : trans('messages.currency.prefix') . number_format($price->salePrice() * $price->cart_min) . trans('messages.currency.suffix');
            }

            return $numeric ? $price->salePrice() : trans('messages.currency.prefix') . number_format($price->salePrice()) . trans('messages.currency.suffix');
        }

        return $numeric ? null : 'ناموجود';
    }

    public function getLowestDiscount($numeric = false, $major_price = false)
    {
        $price = $this->lowestPrice;

        if ($price && $price->hasDiscount()) {
            if ($major_price && $price->cart_min > 0 && $price->cart_min == $price->cart_max) {
                return $numeric ? $price->regularPrice() * $price->cart_min : trans('messages.currency.prefix') . number_format($price->regularPrice() * $price->cart_min) . trans('messages.currency.suffix');
            }

            return $numeric ? $price->regularPrice() : trans('messages.currency.prefix') . number_format($price->regularPrice()) . trans('messages.currency.suffix');
        }

        return null;
    }

    public function getDiscountAttribute()
    {
        $price = $this->lowestPrice;

        if ($price && $price->hasDiscount()) {
            return $price->discount();
        }

        return null;
    }

    public function getDiscount()
    {
        $price = $this->lowestPrice;

        if ($price && $price->hasDiscount()) {
            return $price->discount();
        }

        return null;
    }

    public function get_attributes($attributeGroup, $prev_attribute, $groups, $attributes_id)
    {
        $prices = $this->prices()->pluck('id');

        $group_attributes = $attributeGroup->get_attributes()->pluck('id');
        $attributes = DB::table('attribute_price')->whereIn('price_id', $prices)->whereIn('attribute_id', $group_attributes);

        if ($groups) {
            $group_prices = $this->prices();

            foreach ($attributes_id as $att) {
                $group_prices->whereHas('get_attributes', function ($q) use ($att) {
                    $q->where('attribute_id', $att);
                });
            }

            $group_prices = $group_prices->pluck('id');

            $attributes->whereIn('price_id', $group_prices);
        }

        if ($prev_attribute) {
            $prices_have_this_attribute = $this->prices()->whereHas('get_attributes', function ($q) use ($prev_attribute) {
                $q->where('attribute_id', $prev_attribute->id);
            })->pluck('id');

            $this_price_attributes = DB::table('attribute_price')->whereIn('price_id', $prices_have_this_attribute)->pluck('attribute_id');

            $attributes->whereIn('attribute_id', $this_price_attributes);
        }

        $attributes = $attributes->pluck('attribute_id');

        if ($attributes->count()) {
            return Attribute::whereIn('id', $attributes)->orderBy('ordering')->orderBy('name')->get();
        }

        return null;
    }

    public function hasAttributeStock(Attribute $attribute, $attributes_id = null)
    {

        $query = $this->getPrices()
            ->whereHas('get_attributes', function ($q) use ($attribute) {
                $q->where('attribute_id', $attribute->id);
            })->inStock();

        if ($attributes_id) {
            foreach ($attributes_id as $att) {
                $query->whereHas('get_attributes', function ($q) use ($att) {
                    $q->where('attribute_id', $att);
                });
            }
        }

        return $query->exists();
    }

    public function getPriceWithAttributes($attributes_id)
    {
        foreach ($this->getPrices as $price) {
            $price_attributes = $price->get_attributes()->pluck('attributes.id')->toArray();

            sort($price_attributes);
            sort($attributes_id);

            if ($price_attributes == $attributes_id) {
                return $price;
            }
        }
    }

    public function imageUrl($default = '/empty.jpg')
    {
        if ($this->image) {
            return asset($this->image);
        }

        return $default == '/empty.jpg' ? asset($default) : $default;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public static function clearCache()
    {
        $cache_keys = config('front.cache-forget.products');

        if ($cache_keys) {
            foreach ($cache_keys as $key) {
                Cache::forget($key);
            }
        }

        $cache_keys = self::cacheKeys();

        foreach ($cache_keys as $key) {
            Cache::forget($key);
        }
    }

    public function increaseViewCount()
    {
        $this->increment('view');
    }

    public function getLabels()
    {
        return implode(',', $this->labels()->pluck('title')->toArray());
    }

    public function isSinglePrice()
    {
        return $this->getPrices()->count() == 1 && cart_max($this->getPrices()->first()) == 1;
    }

    public static function cacheKeys()
    {
        return [
            'admin.products_count'
        ];
    }

    public function refreshRating()
    {
        $rating = $this->reviews()->accepted()->sum('rating') / ($this->reviews()->accepted()->count() ?: 1);

        $this->update([
            'rating' => $rating,
            'reviews_count' => $this->reviews()->accepted()->count()
        ]);
    }

    public function suggestionCount()
    {
        return $this->reviews()->accepted()->where('suggest', 'yes')->count();
    }

    public function suggestionPercent()
    {
        return ($this->suggestionCount() * 100) / $this->reviews()->accepted()->count();
    }

    public function sizeType()
    {
        return $this->belongsTo(SizeType::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)
            ->withPivot(['value', 'group', 'ordering'])
            ->withTimestamps()
            ->orderBy('group')
            ->orderBy('ordering');
    }
}
