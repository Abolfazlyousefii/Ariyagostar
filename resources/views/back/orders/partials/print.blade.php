

<div class="container mt-1 p-0 print-border single-order-form">
    <div class="row" dir="rtl">
        <div class="col-md-9">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="text-center">
                        <h4 class="mb-0" style="padding-top: 4px;">صورتحساب فروش کالا و خدمات</h4>
                    </div>
                </div>
                <div class="col-12 text-center" style="padding-top: 10px;">
                    <h2>{{ option('factor_title', option('info_site_title')) }}</h2>
                </div>

            </div>
        </div>
        <div class="col-md-3 factor-header-info print-border-right">
            <div>
                <b>شماره فاکتور:</b>
                <span>{{ $order->id }}</span>
            </div>
            <div>
                <b>تاریخ فاکتور:</b>
                <span>{{ jdate($order->created_at)->format('Y/m/d') }}</span>
            </div>
            <div>
                <img style="height: 30px;object-fit: contain; margin: 4px 0px" src="{{ barcode($order->id) }}" alt="barcode">
            </div>
        </div>

        <div class="col-12">
            <div class="row mx-0">
                <div class="col-12 mb-1 print-border-top factor-table-color">
                    <h6 class="print-title font-weight-bold">مشخصات فروشنده</h6>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">فروشنده:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ option('factor_title', option('info_site_title')) }}</span>
                        </div>
                    </div>
                </div>

                @if (option('factor_national_code'))
                    <div class="col-4">
                        <div class="row">
                            <div class="col-4">
                                <strong class="title font-weight-bold">شناسه ملی:</strong>
                            </div>
                            <div class="col-8">
                                <span>{{ option('factor_national_code') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if (option('factor_registeration_id'))
                    <div class="col-4">
                        <div class="row">
                            <div class="col-4">
                                <strong class="title font-weight-bold">شناسه ثبت:</strong>
                            </div>
                            <div class="col-8">
                                <span>{{ option('factor_registeration_id') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if (option('factor_economical_number'))
                    <div class="col-4">
                        <div class="row">
                            <div class="col-4">
                                <strong class="title font-weight-bold">شماره اقتصادی:</strong>
                            </div>
                            <div class="col-8">
                                <span>{{ option('factor_economical_number') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">کدپستی:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ option('info_postal_code') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">شماره تماس:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ option('info_tel') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-1">
                            <strong class="title font-weight-bold">نشانی:</strong>
                        </div>
                        <div class="col-10 pl-3">
                            <span>{{ option('info_address') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row mx-0">
                <div class="col-12 mb-1 factor-table-color">
                    <h6 class="print-title font-weight-bold">مشخصات خریدار</h6>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">نام:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ $order->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">شماره ملی:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ $order->user->national_code ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">شماره تماس:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ $order->mobile }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">کدپستی:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ $order->postal_code }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">شیوه حمل ونقل:</strong>
                        </div>
                        <div class="col-8">
                            <span>{{ $order->carrier->title ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <strong class="title font-weight-bold">نحوه پرداخت:</strong>
                        </div>
                        <div class="col-8">
                            <span>پرداخت آنلاین</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-1">
                            <strong class="title font-weight-bold">نشانی:</strong>
                        </div>
                        <div class="col-10 pl-3">
                            <span>{{ $order->province->name ?? '' }} - {{ $order->city->name ?? '' }} - {{ $order->address }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table class="table mb-0 print-border-top">
                <thead>
                <tr class="print-factor factor-table-color">
                    <th class="border-0" scope="col">ردیف</th>
                    <th class="border-0" scope="col">کد کالا</th>
                    <th class="border-0 text-center" scope="col">شرح کالا</th>
                    <th class="border-0" scope="col">تعداد</th>
                    <th class="border-0" scope="col">مبلغ واحد</th>
                    <th class="border-0" scope="col">مبلغ کل</th>
                    <th class="border-0" scope="col">تخفیف</th>
                    <th class="border-0" scope="col">مبلغ نهایی</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <th class="" scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->product_id }}</td>
                        <td class="text-center">{{ $item->title }} @if ($item->get_price)<p>{{ $item->get_price->getAttributesName() }}</p> @endif</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->realPrice()) }}</td>
                        <td>{{ number_format($item->quantity * $item->realPrice()) }}</td>
                        <td>{{ $item->discount ? $item->discount . '%' : 0 }}</td>
                        <td class="">{{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-12">
            <div class="row justify-content-end m-0">
                <div class="col-8 pl-0">
                    <div style="margin-bottom: 5px">
                        <div class="print-factor">
                            <h5 class="text-muted">توضیحات:</h5> <span>{{ $order->description }}</span>
                            @if ($order->reservedOrders()->count())
                                <small>سفارش هایی که قبلا رزرو شده اند و به همراه این سفارش ارسال میشوند:</small>
                                <div>
                                    @foreach ($order->reservedOrders as $reserved_order)
                                        <span class="text-success">سفارش شماره {{ $reserved_order->id }} {{ $loop->last ? '' : ' و ' }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-4 pr-0">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th class="p-0">مجموع:</th>
                            <td class="p-0">{{ number_format($order->price - $order->shipping_cost) }}</td>
                        </tr>
                        <tr>
                            <th class="p-0">هزینه حمل و نقل:</th>
                            <td class="p-0">{{ number_format($order->shipping_cost) }}</td>
                        </tr>
                        <tr>
                            <th class="p-0">مجموع تخفیف:</th>
                            <td class="p-0">{{ number_format($order->totalDiscount()) }}</td>
                        </tr>

                        <tr class="factor-table-color">
                            <th class="p-0">مجموع فاکتور:</th>
                            <td class="p-0">{{ number_format($order->price) }} تومان</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container p-0 mt-1 d-print-none">
    <div class="row">
        <div class="col-12 text-right">
            <a target="_blank" href="{{ route('admin.orders.show', ['order' => $order]) }}" class="btn btn-light">مشاهده</a>
            <button onclick="window.print();" class="btn btn-light">چاپ</button>
        </div>
    </div>
</div>
