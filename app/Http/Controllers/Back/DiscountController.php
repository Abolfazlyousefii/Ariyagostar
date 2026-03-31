<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Discount\StoreDiscountRequest;
use App\Http\Requests\Back\Discount\UpdateDiscountRequest;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Discount::class, 'discount');
    }

    public function index()
    {
        $discounts = Discount::detectLang()->latest();
        $users = User::whereHas("discounts")->get();

        if(request()->code)
        {
            $discounts = $discounts->where('code', "LIKE", "%" .request()->code."%");
        }

        if(request()->user_id){
            $discounts = $discounts->whereRelation("users", "users.id", "=", request()->user_id);
        }

        $discounts = $discounts->paginate(20);

        return view('back.discounts.index', compact('discounts', 'users'));
    }

    public function create()
    {
        $users      = User::latest()->get();
        $products   = Product::latest()->get();
        $categories = Category::where('type', 'productcat')->orderBy('ordering')->get();

        return view('back.discounts.create', compact(
            'users',
            'categories',
            'products'
        ));
    }

    public function store(StoreDiscountRequest $request)
    {
        $data = $request->validated();

        if (isset($data['type'])) {
            $data['amount']        =  $data['type'] == 'amount' ? $data['price'] : $data['percent'];
        }else{
            $data['amount'] = 0;
        }

        $data['start_date']    = isset($data['start_date']) && $data['start_date'] ? Jalalian::fromFormat('Y-m-d H:i:s', $data['start_date'])->toCarbon() : now();
        $data['end_date']      = Jalalian::fromFormat('Y-m-d H:i:s', $data['end_date'])->toCarbon();
        $data['lang']          = app()->getLocale();

        $discount = Discount::create($data);

        DB::beginTransaction();
        try {
            $this->updateRelations($discount, $request);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        DB::commit();

        toastr()->success('تخفیف با موفقیت ایجاد شد.');

        return response('success');
    }

    public function edit(Discount $discount)
    {
        $users      = User::latest()->get();
        $products   = Product::latest()->get();
        $categories = Category::where('type', 'productcat')->orderBy('ordering')->get();

        return view('back.discounts.edit', compact('users', 'categories', 'products', 'discount'));
    }

    public function update(Discount $discount, UpdateDiscountRequest $request)
    {
        $data = $request->validated();

        if (isset($data['type'])) {
            $data['amount']        =  $data['type'] == 'amount' ? $data['price'] : $data['percent'];
        }else{
            $data['amount'] = 0;
        }

        $data['start_date']    = isset($data['start_date']) && $data['start_date'] ? Jalalian::fromFormat('Y-m-d H:i:s', $data['start_date'])->toCarbon() : now();
        $data['end_date']      = Jalalian::fromFormat('Y-m-d H:i:s', $data['end_date'])->toCarbon();
        $data['lang']          = app()->getLocale();

        DB::beginTransaction();
        try {

            $discount->update($data);

            $this->updateRelations($discount, $request);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        DB::commit();
        toastr()->success('تخفیف با موفقیت ویرایش شد.');

        return response('success');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response('success');
    }

    private function updateRelations(Discount $discount, $request)
    {
        $discount->includeCategories()->detach();
        $discount->includeProducts()->detach();

        if ($request->include_type == 'category') {
            $discount->includeCategories()->attach($request->include_categories, ['type' => 'include']);
        }

        if ($request->exclude_type == 'category') {
            $discount->excludeCategories()->attach($request->exclude_categories, ['type' => 'exclude']);
        }

        if ($request->include_type == 'product') {
            $discount->includeProducts()->attach($request->include_products, ['type' => 'include']);
        }

        if ($request->exclude_type == 'product') {
            $discount->excludeProducts()->attach($request->exclude_products, ['type' => 'exclude']);
        }

        if ($request->get("method") == "direct") {
            foreach ($discount->allProducts() as $product) {
                foreach ($product->prices as $price) {
                    $discount_price = $price->regular_price * $request->percent / 100;
                    if ($request->discount_ceiling && $discount_price > $request->discount_ceiling) {
                        $discount_price = $request->discount_ceiling;
                        $percent  = $discount_price * 100 / $price->regular_price;
                    } else {
                        $percent  = $request->percent;
                    }

                    $discount_price = $price->regular_price - $discount_price;


                    $price->update([
                        "discount" => $percent,
                        "discount_price" => $discount_price,
                        "discount_expire_at" => Jalalian::fromFormat('Y-m-d H:i:s', $request['end_date'])->toCarbon()
                    ]);
                }
            }
        }

        $discount->users()->sync($request->users);
    }
}
