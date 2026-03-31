<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'price_id', 'id'])->withTimestamps();
    }

    public function prices()
    {
        return $this->belongsToMany(Price::class, 'cart_product');
    }

    public function getPriceAttribute()
    {
        $price = 0;

        foreach ($this->products as $product) {
            $price += ($product->prices()->find($product->pivot->price_id)->salePrice() * $product->pivot->quantity);
        }

        return $price;
    }

    public function discountPrice()
    {
        $price = 0;

        foreach ($this->products as $product) {
            $product_price = $product->prices()->find($product->pivot->price_id);
            $price += ($product_price->salePrice() * $product->pivot->quantity);
        }

        return $price;
    }

    public function finalPrice()
    {
        $price  = $this->discountPrice() + $this->shippingCostAmount();
        $price -= $this->discountCodeTotal();

        return intval($price);
    }

    public function getQuantityAttribute()
    {
        $quantity = 0;

        foreach ($this->products as $product) {
            $quantity += $product->pivot->quantity;
        }

        return $quantity;
    }

    public function shippingCostAmount()
    {
        if (!$this->hasPhysicalProduct() || $this->reserved()) {
            return 0;
        }

        if ($this->city_id && $this->carrier_id) {

            $carrier_result = self::canUseCarrier($this->carrier_id, $this->weight(), $this->city_id);

            if ($carrier_result['status']) {
                $carrier       = $carrier_result['carrier'];
                $cart_weight   = $this->weight();

                if ($carrier->carrige_forward || ($carrier->free_shipping_weight !== null && $carrier->free_shipping_weight <= $cart_weight)) {
                    return 0;
                }

                if ($carrier->free_shipping_price !== null && $carrier->free_shipping_price <= $this->discountPrice()) {
                    return 0;
                }

                $tariff = $carrier->getCityTarif($this->city_id, $cart_weight);

                $shipping_cost = $tariff->shipping_cost;

                $carrier_max_weight = $carrier->max_package_weight;

                if ($carrier_max_weight && $cart_weight > $carrier_max_weight) {
                    $weight_diff = ($cart_weight - $carrier_max_weight) / 1000;

                    $shipping_cost += ((int) $weight_diff * $carrier->extra_cost);
                }

                return $shipping_cost;
            }
        }

        return 0;
    }

    public function shippingCost()
    {
        if (!$this->hasPhysicalProduct() || $this->reserved()) {
            return 'بدون ارسال';
        }

        $amount = $this->shippingCostAmount();

        if ($this->carrier_id) {
            $carrier = Carrier::find($this->carrier_id);

            if ($carrier->carrige_forward) {
                return 'به عهده مشتری';
            }
        }

        if ($this->city_id) {
            if ($amount == 0) {
                return 'رایگان';
            }

            return trans('messages.currency.prefix') . number_format($amount) . trans('messages.currency.suffix');
        }

        return 'وابسته به آدرس';
    }

    public function totalDiscount()
    {
        $discount = 0;

        foreach ($this->products as $product) {
            $product_price = $product->prices()->find($product->pivot->price_id);

            if ($product_price->hasDiscount()) {
                $discount += ($product_price->regularPrice() * $product->pivot->quantity) - ($product_price->discountPrice() * $product->pivot->quantity);
            }
        }

        return $discount + $this->discountCodeTotal();
    }

    public function canUseDiscount($code = null)
    {
        if (!$code) {
            $discount = $this->discount;
        } else {
            $discount = Discount::where('code', $code)->where('published', true)->first();
        }

        if (!$discount || !$discount->published) {
            return [
                'status'  => false,
                'message' => 'کد تخفیف وارد شده معتبر نمی باشد.'
            ];
        }

        if (Carbon::parse($discount->start_date)->isFuture()) {
            return [
                'status'  => false,
                'message' => 'تاریخ شروع کد تخفیف فرا نرسیده است.'
            ];
        }

        if (Carbon::parse($discount->end_date)->isPast()) {
            return [
                'status'  => false,
                'message' => 'تاریخ استفاده از کد تخفیف به پایان رسیده است.'
            ];
        }

        if ($discount->users()->count() && !$discount->users()->find(auth()->user()->id)) {
            return [
                'status'  => false,
                'message' => 'شما مجاز به استفاده از این کد تخفیف نیستید.'
            ];
        }

        if ($discount->only_first_purchase && auth()->user()->orders()->notCanceled()->count()) {
            return [
                'status'  => false,
                'message' => 'این تخفیف فقط مخصوص اولین خرید میباشد.'
            ];
        }

        if ($discount->quantity !== null && $discount->orders()->notCanceled()->count() >= $discount->quantity) {
            return [
                'status'  => false,
                'message' => 'تعداد استفاده از کد تخفیف به پایان رسید است.'
            ];
        }

        if ($discount->quantity_per_user !== null && $discount->orders()->notCanceled()->where('user_id', auth()->user()->id)->count() >= $discount->quantity_per_user) {
            return [
                'status'  => false,
                'message' => 'تعداد استفاده شما از این کد تخفیف به پایان رسیده است.'
            ];
        }

        if ($discount->least_price !== null && $this->price < $discount->least_price) {
            return [
                'status'  => false,
                'message' => "حداقل قیمت سفارش برای این کد تخفیف " . number_format($discount->least_price) . " تومان می باشد."
            ];
        }

        if ($discount->least_products_count && $this->products()->sum('cart_product.quantity') < $discount->least_products_count) {
            return [
                'status'  => false,
                'message' => "حداقل تعداد کالای سفارش برای این کد تخفیف " . $discount->least_products_count . " عدد می باشد."
            ];
        }

        if ($discount->type == 'amount' && $this->price < $discount->amount) {
            return [
                'status'  => false,
                'message' => "مبلغ تخفیف بیشتر از مبلغ فاکتور است."
            ];
        }

        if ($discount->method == 'carrier' && $this->carrier->carrige_forward) {
            return [
                'status'  => false,
                'message' => "امکان استفاده از کد تخفیف ارسال رایگان برای پرداخت پس کرایه موجود نمی باشد."
            ];
        }

        return ['status' => true, 'message' => 'ok'];
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function discountCodeTotal()
    {
        $discount = $this->discount;

        if (!$discount) {
            return 0;
        }

        $price = $this->includeDiscountProductsPrice();

        if($discount->method == "carrier"){
            return $this->shippingCostAmount();
        }

        if ($discount->type == 'amount') {
            return $price > $discount->amount ? $discount->amount : $price;
        }

        $discount_amount = $price * ($discount->amount / 100);

        if ($discount->discount_ceiling && $discount_amount > $discount->discount_ceiling) {
            return $discount->discount_ceiling;
        }



        return $discount_amount;
    }

    public function includeDiscountProductsPrice()
    {
        $query = $this->products();

        if ($this->discount->include_type == 'product') {
            $include_products   = $this->discount->includeProducts()->pluck('products.id');
            $query->whereIn('products.id', $include_products);
        }

        if ($this->discount->include_type == 'category') {
            $include_categories = [];
            $categories         = $this->discount->includeCategories()->pluck('categories.id');

            $categories = Category::whereIn('id', $categories)->get();

            foreach ($categories as $category) {
                $include_categories = array_merge($include_categories, $category->allChildCategories());
            }

            $query->whereHas('categories', function ($q) use ($include_categories) {
                $q->whereIn('categories.id', $include_categories);
            });
        }

        if ($this->discount->exclude_type == 'product') {
            $exclude_products   = $this->discount->excludeProducts()->pluck('products.id');
            $query->whereNotIn('products.id', $exclude_products);
        }

        if ($this->discount->exclude_type == 'category') {
            $exclude_categories = $this->discount->excludeCategories()->pluck('categories.id');

            $query->whereDoesntHave('categories', function ($q) use ($exclude_categories) {
                $q->whereIn('categories.id', $exclude_categories);
            });
        }

        $price = 0;

        foreach ($query->get() as $product) {
            $product_price = $product->prices()->find($product->pivot->price_id);

            if (!$product_price->discount || !$this->discount->not_discount_products) {
                $price += ($product_price->price * $product->pivot->quantity);
            }
        }

        return $price;
    }

    public function hasPhysicalProduct()
    {
        if ($this->reserved()) return false;

        foreach ($this->products as $product) {
            if ($product->isPhysical()) {
                return true;
            }
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weight()
    {
        $weight = 0;

        if ($this->user && $this->send_reserved_orders) {
            $weight += $this->user->orders()->reserved()->sum('weight');
        }

        foreach ($this->products as $product) {
            $weight += $product->weight * $product->pivot->quantity;
        }

        return $weight;
    }

    public static function canUseCarrier($carrier_id, $weight, $city_id)
    {
        $carrier = Carrier::active()->find($carrier_id);

        if (!$carrier) {
            return [
                'status'  => false,
                'message' => 'روش ارسال پیدا نشد!'
            ];
        }

        if ($carrier->max_package_weight && $carrier->max_package_weight < $weight && !$carrier->extra_cost) {
            return [
                'status'  => false,
                'message' => 'وزن کالاهای سفارش بیشتر از حد مجاز است'
            ];
        }

        if ($carrier->min_package_weight && $carrier->min_package_weight > $weight) {
            return [
                'status'  => false,
                'message' => 'وزن کالاهای سفارش کمتر از حد مجاز است'
            ];
        }

        if ($carrier->covered_cities != 'all') {
            if (!$carrier->cities()->find($city_id)) {
                return [
                    'status'  => false,
                    'message' => 'روش ارسال شامل شهر مورد نظر نمی باشد'
                ];
            }
        }

        if (!$carrier->carrige_forward) {
            $is_within_province = $carrier->province->cities()->find($city_id);

            if ($is_within_province && !$carrier->tariffs()->where('type', 'within_province')->where(function ($query) use ($carrier, $weight) {
                if (!$carrier->extra_cost) {
                    $query->where('max_weight', '>=', $weight);
                }
            })->exists()) {
                return [
                    'status'  => false,
                    'message' => 'تعرفه درون استانی برای روش ارسال ثبت نشده است'
                ];
            } else if (!$is_within_province && !$carrier->tariffs()->where('type', 'extra_province')->where(function ($query) use ($carrier, $weight) {
                if (!$carrier->extra_cost) {
                    $query->where('max_weight', '>=', $weight);
                }
            })->exists()) {
                return [
                    'status'  => false,
                    'message' => 'تعرفه برون استانی برای روش ارسال ثبت نشده است'
                ];
            }
        }

        return [
            'status'  => true,
            'message' => 'ok',
            'carrier' => $carrier,
        ];
    }

    public function reserved()
    {
        return $this->reserve;
    }

    /**
     * Get the carrier that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'id');
    }
}
