<div class="row p-border mb-2 single-order-form" dir="rtl">
    <div class="col-6 px-0">
        <div class="pt-3 p-1">
            <ul class="list-unstyled line-height-2">
                <li><b>گیرنده:</b> <span>{{ $order->province->name ?? '' }} - {{ $order->city->name ?? '' }} - {{ $order->address }}</span></li>
                <li><b>نام کامل:</b> <span>{{ $order->name }}</span></li>
                <li><b>کدپستی</b> <span>{{ $order->postal_code }}</span></li>
                <li><b>تلفن:</b> <span>{{ $order->mobile }}</span></li>
                <li><b>تاریخ سفارش:</b> <span>{{ jdate($order->created_at)->format('Y/m/d') }}</span></li>
            </ul>
            <div>
                <p class="text-center">
                    <img class="w-100" style="height: 40px;object-fit: contain" src="{{ barcode($order->id) }}" alt="barcode">
                </p>
            </div>
        </div>
    </div>
    <div class="col-6 px-0">
        <div class=" p-border-right p-1">
            <div>
                <h4 class="text-center p-border-bottom p-2">
                    @if (option('factor_logo'))
                        <img src="{{ asset(option('factor_logo')) }}" alt="factor_logo"  style="max-height: 50px;">
                    @endif
                    {{ option('info_site_title') }}
                </h4>
            </div>
            <ul class="list-unstyled line-height-2">
                <li><b>آدرس:</b> <span>{{ option('info_address') }}</span></li>
                <li><b>کدپستی:</b> <span>{{ option('info_postal_code') }}</span></li>
                <li><b>تلفن:</b> <span>{{ option('info_tel') }}</span></li>
                <li><b>ایمیل:</b> <span>{{ option('info_email') }}</span></li>
                <li><b>وب سایت:</b> <span>{{ url('/') }}</span></li>

                @if ($order->reservedOrders()->count())
                    <li>
                        <b>توضیحات:</b>
                        <small>سفارش هایی که قبلا رزرو شده اند و به همراه این سفارش ارسال میشوند:</small>
                        <div>
                            @foreach ($order->reservedOrders as $reserved_order)
                                <span class="text-success">سفارش شماره {{ $reserved_order->id }} {{ $loop->last ? '' : ' و ' }}</span>
                            @endforeach
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="print-footer col-12 px-0">
        <ul class="d-flex p-border-top m-0 p-1 justify-content-around list-unstyled">
            <li class="px-1"><b>شناسه سفارش:</b> <span>{{ $order->id }}</span></li>
            <li class="p-border-left"></li>
            <li class="px-1"><b>روش حمل و نقل:</b> <span>{{ $order->carrier->title ?? '' }}</span></li>
            <li class="p-border-left"></li>
            <li class="px-1"><b>روش پرداخت:</b> <span>{{ $order->carrier && $order->carrier->carrige_forward ? 'پس کرایه' : 'پرداخت آنلاین' }}</span></li>
        </ul>
    </div>
</div>
