<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StockNotify;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StockNotifyController extends Controller
{
    public function store(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();

            $this->validate($request, [
                'product_id' => [
                    'required',
                    Rule::exists('products', 'id', function ($query) {
                        return $query->where('type', 'physical')->where('stock', 0);
                    }),
                ]
            ]);

            StockNotify::firstOrCreate(
                [
                    'mobile'     => $user->username,
                    'product_id' => $request->product_id,
                    'seen'       => false
                ],
                [
                    'name'       => $user->fullname,
                    'email'      => $user->email,
                ]
            );

            return response('success');
        }

        $this->validate($request, [
            'name'   => 'required|string',
            'mobile' => 'required|string|regex:/(09)[0-9]{9}/|digits:11',
            'email'  => 'nullable|email',
        ]);

        StockNotify::firstOrCreate(
            [
                'mobile'     => $request->mobile,
                'product_id' => $request->product_id,
                'seen'       => false
            ],
            [
                'name'       => $request->name,
                'email'      => $request->email,
            ]
        );

        return response('success');
    }
}
