<?php

namespace App\Http\Controllers\Back;

use App\Events\ProductPricesChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Currency\StoreCurrencyRequest;
use App\Http\Requests\Back\Currency\UpdateCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Currency::class, 'currency');
    }

    public function index()
    {
        $currencies = Currency::detectLang()->latest()->paginate(20);

        return view('back.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('back.currencies.create');
    }

    public function store(StoreCurrencyRequest $request)
    {
        $data         = $request->validated();
        $data['lang'] = app()->getLocale();

        Currency::create($data);

        toastr()->success('ارز با موفقیت ایجاد شد.');

        return response('success');
    }

    public function edit(Currency $currency)
    {
        return view('back.currencies.edit', compact('currency'));
    }

    public function update(Currency $currency, UpdateCurrencyRequest $request)
    {
        $data       = $request->validated();
        $old_amount = $currency->amount;

        $currency->update($data);

        if ($old_amount != $data['amount']) {
            $products = $currency->products()->get();

            foreach ($products as $product) {

                foreach ($product->prices as $price) {
                    $price->update([
                        'discount_price' => get_discount_price($price->price, $price->discount, $price->product),
                        'regular_price'  => get_discount_price($price->price, 0, $price->product),
                    ]);
                }

                event(new ProductPricesChanged($product));
            }
        }

        toastr()->success('ارز با موفقیت ویرایش شد.');

        return response('success');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response('success');
    }
}
