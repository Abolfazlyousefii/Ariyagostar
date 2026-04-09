<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Taggable;
use App\Traits\Languageable;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\CategoryRepository;
use Spatie\Sitemap\Contracts\Sitemapable;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model implements Sitemapable
{
    use sluggable, Taggable, CategoryRepository, Languageable;

    public const MAIN_PRODUCT_CATEGORY_TITLES = ['mobile', 'موبایل', 'guard', 'گارد'];

    protected $guarded = ['id'];

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route("front.products.category-products", ["category" => $this]))
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

    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('ordering');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories')->orderBy('ordering');
    }

    public function allChildCategories()
    {
        $categories = $this->categories()->pluck('id')->toArray();
        $categories[] = $this->id;

        foreach ($this->categories as $category) {
            $categories = array_merge($categories, $category->allChildCategories());
        }

        return $categories;
    }

    /**
     * Get all of the getAllProducts for the Category
     *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function allProductsRel(): HasMany
    // {
    //     return $this->hasMany(Product::class, 'category_id', 'id');
    // }

    // public function getAllProducts(){
    //     $categories = $this->allChildCategories();

    //     $all_products = collect();

    //     $products = Product::whereHas('categories', function ($query) use ($categories) {
    //         $query->whereIn('categories.id', $categories);
    //     })->orWhereIn("category_id", $categories);

    //     // foreach ($categories as $category) {
    //     //     $all_products->push($category->allProductsRel);
    //     // }

    //     // $all_products->push($products->get());

    //     // $all_products->push($this->allProductsRel);


    //     dd($products->get());


    //     return $products;
    // }

    public function allProducts()
    {
        $categories = $this->allChildCategories();

        $products = Product::whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('categories.id', $categories);
        })->orWhereIn("category_id", $categories);

        return $products;
    }

    public function allPublishedProducts()
    {
        $categories = $this->allChildCategories();

        $products = Product::published()->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('categories.id', $categories)->published();
        });

        return $products;
    }

    public function productsCount()
    {
        return $this->allProducts()->count();
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menus', 'menuable_id')->where('type', 'category');
    }

    public function getFullTitleAttribute()
    {
        if ($this->category_id) {
            $category_id = $this->category_id;
            $value = [$this->title];
            do {
                $mother = Category::find($category_id);
                $value[] = $mother->title;
                $category_id = $mother->category_id;
            } while ($category_id);

            $value = array_reverse($value);

            return implode(' - ', $value);
        }

        return $this->title;
    }

    public function getLinkAttribute()
    {
        if ($this->type == 'productcat') {
            return route('front.products.category-products', ['category' => $this]);
        }

        return route('front.blog.category', ['category' => $this]);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function parents()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents->reverse();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }

    public function getFilter()
    {
        if ($this->filter_type == 'none') {
            return null;
        }

        $filter = $this->filter;

        if (!$filter) {
            $parent = $this->parent;

            while ($parent) {
                $filter = $parent->filter;

                if ($filter) {
                    break;
                }

                $parent = $parent->parent;
            }
        }

        return $filter;
    }

    public function scopeGetWithChilds($query)
    {
        $categories = $query->get();
        $all_categories = Category::get();

        $this->setCategoriesRelations($categories, $all_categories);

        return $categories;
    }

    private function setCategoriesRelations($categories, $all_categories)
    {
        foreach ($categories as $category) {
            if ($all_categories->where('category_id', $category->id)->count()) {
                $category->setRelation('categories', $all_categories->where('category_id', $category->id));
                $this->setCategoriesRelations($all_categories->where('category_id', $category->id), $all_categories);
            }
        }
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeMainProductCategories($query)
    {
        return $query
            ->where('type', 'productcat')
            ->whereNull('category_id')
            ->where(function ($query) {
                foreach (self::MAIN_PRODUCT_CATEGORY_TITLES as $title) {
                    $query->orWhereRaw('LOWER(title) = ?', [mb_strtolower($title)]);
                }
            });
    }

    public function isPublished()
    {
        return $this->published;
    }
}
