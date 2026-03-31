<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes, Languageable;

    protected $guarded = ['id'];

    public  function includeCategories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot(['type'])
            ->where('category_discount.type', 'include');
    }

    public  function excludeCategories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot(['type'])
            ->where('category_discount.type', 'exclude');
    }

    public  function includeProducts()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['type'])
            ->where('discount_product.type', 'include');
    }

    public  function excludeProducts()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['type'])
            ->where('discount_product.type', 'exclude');
    }

    public function allProducts(){
        $categories = $this->includeCategories;
        $products = collect();
        foreach ($categories as $category) {
            $products->push($category->allProducts()->get());
        }
        return $products->collapse();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
