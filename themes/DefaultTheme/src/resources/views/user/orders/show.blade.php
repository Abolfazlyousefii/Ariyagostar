@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="row">

            @if(session('message') == 'ok')

                <div class="col-12">
                    <div class="checkout-alert dt-sn mb-4">
                        <div class="circle-box-icon successful">
                            <i class="mdi mdi-check-bold"></i>
                        </div>
                        <div class="checkout-alert-title">
                            <h4> {{ trans('front::messages.profile.your-order-with-order-number') }}<span class="checkout-alert-highlighted checkout-alert-highlighted-success">{{ $order->id }}</span>
                                {{ trans('front::messages.profile.success-registered-system') }}
                            </h4>
                        </div>

                    </div>
                </div>
            @elseif(session('transaction-error'))
                <div class="col-12">
                    <div class="checkout-alert dt-sn mb-4">
                        <div class="circle-box-icon failed">
                            <i class="mdi mdi-close"></i>
                        </div>
                        <div class="checkout-alert-title">
                            <h4> {{ trans('front::messages.profile.order') }} <span class="checkout-alert-highlighted checkout-alert-highlighted-success">{{ $order->id }}</span>
                                {{ trans('front::messages.profile.registered') }}
                            </h4>
                        </div>
                        <div class="checkout-alert-content">
                            <p>
                                <span class="checkout-alert-content-failed">{{ trans('front::messages.profile.system-cancellation', ['minutes' => option('orders_cancel_time', 60)]) }}</span>
                                <br>
                                <span class="checkout-alert-content-small px-res-1">
                                    {{ trans('front::messages.profile.deduction-from-the-account') }}
                                </span>
                            </p>
                        </div>
                        @if($order->status == 'unpaid')
                            <div class="text-center">
                                <a href="{{ route('front.orders.pay', ['order' => $order]) . '?gateway=' . ($order->gatewayRelation ? $order->gatewayRelation->key : 'wallet') }}" class="btn btn-light">
                                    {{ trans('front::messages.profile.order-payment') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-12 text-center">
                    <div class="alert alert-danger mt-4" role="alert">
                        <strong>{{ session('transaction-error') }}</strong>.
                    </div>
                </div>
            @elseif(session('error'))

                <div class="col-lg-12 text-center">
                    <div class="alert alert-danger mt-4" role="alert">
                        <strong>{{ session('error') }}</strong>.
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="profile-navbar">
                    <h4>{{ trans('front::messages.profile.order-number') }}<span class="font-en">{{ $order->id }}</span><span>{{ trans('front::messages.profile.recorded-on') }}{{ jdate($order->created_at)->format('%d %B %Y') }}</span></h4>
                </div>
            </div>

            @if ($order->reserved() && $order->isPaid())
                <div class="col-lg-12 text-center">
                    <div class="alert alert-warning mt-4" role="alert">
                        <strong>این سفارش رزرو شده و میتوانید همراه با سفارش بعدی تان درخواست ارسال کنید</strong>
                        <p class="mt-2">اگر سفارش جدید ندارید میتوانید هزینه ارسال را پرداخت کنید تا سفارش تان را برایتان ارسال کنیم <a href="{{ route('front.orders.edit', ['order' => $order]) }}">پرداخت هزینه ارسال</a></p>
                    </div>
                </div>
            @endif

            <div class="col-12 mb-4">
                <div class="dt-sl dt-sn">
                    <div class="row table-draught px-3">
                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.transferee') }}</span>
                            <span class="value">{{ $order->name }}</span>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.recipient-contact-number') }}</span>
                            <span class="value">{{ $order->mobile }}</span>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.shipping-cost') }}</span>
                            @if ($order->shipping_cost)
                                <span class="value">{{ trans('front::messages.currency.prefix') }}{{ number_format($order->shipping_cost) }}{{ trans('front::messages.currency.suffix') }}</span>
                            @elseif ($order->reserved())
                                <span class="value">{{ trans('front::messages.profile.reserved') }}</span>
                            @elseif ($order->carrier && $order->carrier->carrige_forward)
                                <span class="value">{{ trans('front::messages.profile.so-rent') }}</span>
                            @else
                                <span class="value">{{ trans('front::messages.profile.free') }}</span>
                            @endif

                        </div>

                        @if ($order->hasPhysicalProduct())
                            <div class="col-md-6 col-sm-12">
                                <span class="title">{{ trans('front::messages.profile.how-to-send-order') }}</span>
                                <span class="value">{{ $order->carrier ? $order->carrier->title : trans('front::messages.profile.unknown') }}</span>
                            </div>
                        @endif

                        @if ($order->province)
                            <div class="col-md-6 col-sm-12">
                                <span class="title">{{ trans('front::messages.profile.address') }}</span>
                                <span class="value">{{ $order->province->name . ' - ' . $order->city->name }}</span>
                            </div>
                        @endif


                        @if ($order->address)
                            <div class="col-md-6 col-sm-12">
                                <span class="title">{{ trans('front::messages.profile.complete-address') }}</span>
                                <span class="value">{{ $order->address }}</span>
                            </div>
                        @endif

                        @if ($order->postal_code)
                            <div class="col-md-6 col-sm-12">
                                <span class="title">{{ trans('front::messages.profile.postal-code') }}</span>
                                <span class="value">{{ $order->postal_code }}</span>
                            </div>
                        @endif

                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.payment-method') }}</span>
                            @if ($order->walletHistory)
                                <span class="value">{{ trans('front::messages.profile.pay-with-wallet') }}</span>
                            @else
                                <span class="value">{{ trans('front::messages.profile.online-payment') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.order-description') }}</span>
                            <span class="value">{{ $order->description ? $order->description : '-' }}</span>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.payment-status') }}</span>
                            <span class="value">
                                @if($order->status == 'paid')
                                {{ trans('front::messages.profile.paid') }}
                                @elseif($order->status == 'unpaid')
                                {{ trans('front::messages.profile.unpaid') }} ( {{ trans('front::messages.profile.select-payment-gateway') }} )
                                @else
                                {{ trans('front::messages.profile.canceled') }}
                                @endif
                            </span>

                            @if($order->status == 'unpaid')
                                <form action="{{ route('front.orders.pay', ['order' => $order]) }}" method="GET">
                                    <div class="row p-0">
                                        <div class="col-sm-8 border-none py-0 mb-2 mb-sm-0">
                                            <select class="form-control py-0" name="gateway" required>
                                                <option value="">{{ trans('front::messages.profile.Select') }}</option>
                                                @if ($wallet->balance >= $order->price)
                                                    <option value="wallet">{{ trans('front::messages.profile.pay-with-wallet') }}</option>
                                                @elseif ($wallet->balance)
                                                    <option value="wallet">{{ trans('front::messages.profile.charging-and-payment') }}</option>
                                                @endif

                                                @foreach ($gateways as $gateway)
                                                    <option value="{{ $gateway->key }}">{{ $gateway->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 border-none py-0">
                                            <button type="submit" class="btn btn-light">
                                                {{ trans('front::messages.profile.order-payment') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.total-discount') }}</span>
                            <span class="value">{{ trans('front::messages.currency.prefix') }}{{ number_format($order->totalDiscount()) }}{{ trans('front::messages.currency.suffix') }}</span>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <span class="title">{{ trans('front::messages.profile.total-price') }}</span>
                            <span class="value">{{ trans('front::messages.currency.prefix') }}{{ number_format($order->price) }} {{ trans('front::messages.currency.suffix') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($order->status == 'paid' && $order->hasPhysicalProduct() && !$order->reserved())
                <div class="col-12 mb-4">
                    <section class="slider-section dt-sl mb-0">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="section-title text-sm-title title-wide no-after-title-wide">
                                    <h2> {{ trans('front::messages.profile.post-status') }} @if($order->shipping_status == 'canceled') <small class="text-danger">( {{ trans('front::messages.profile.posting-canceled') }} )</small> @endif </h2>
                                </div>
                            </div>

                            <!-- Start Profile-order-step-Slider -->
                            <div class="col-12">
                                <div class="profile-order-steps  owl-carousel owl-theme">
                                    <div class="item profile-order-steps-item {{ in_array($order->shipping_status, ['pending', 'wating', 'sent']) ? 'is-active' : '' }}">
                                        <img data-src="{{ theme_asset('img/svg/0eab59b0.svg') }}">
                                        <span>{{ trans('front::messages.profile.pending') }}</span>
                                    </div>

                                    <div class="item profile-order-steps-item {{ in_array($order->shipping_status, ['wating', 'sent']) ? 'is-active' : '' }}">
                                        <img data-src="{{ theme_asset('img/svg/3db3cdeb.svg') }}">
                                        <span>{{ trans('front::messages.profile.waiting-to-send') }}</span>
                                    </div>
                                    <div class="item profile-order-steps-item last-item {{ in_array($order->shipping_status, ['sent']) ? 'is-active' : '' }}">
                                        <img data-src="{{ theme_asset('img/svg/332b9ff1.svg') }}">
                                        <span>{{ trans('front::messages.profile.sent') }}</span>
                                    </div>

                                </div>
                            </div>
                            <!-- End Profile-order-step-Slider -->
                        </div>
                        @if ($order->tracking_code)
                            <div class="d-flex justify-content-center mb-3">
                                <div class="col-5 text-center tracking_code">
                                    {{ trans('front::messages.profile.tracking-code') . ' ' . $order->tracking_code }}
                                </div>
                            </div>
                        @endif
                    </section>
                </div>
            @endif

            @if ($order->reservedOrders()->count())
                <div class="col-12">
                    <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                        <h2>لیست سفارش های رزرو شده قبلی</h2>
                    </div>
                    <div class="dt-sl">
                        <div class="table-responsive">
                            <table class="table table-order table-order-details">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>شماره سفارش</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->reservedOrders as $reserved_order)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $reserved_order->id }}
                                            </td>
                                            <td>
                                                {{ jdate($reserved_order->created_at) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('front.orders.show', ['order' => $reserved_order]) }}" class="btn btn-info mb-2">مشاهده</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12 mt-3">
                <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                    <h2>{{ trans('front::messages.profile.all-orders') }}</h2>
                </div>
                <div class="dt-sl">
                    <div class="table-responsive">
                        <table class="table table-order table-order-details">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('front::messages.profile.product-name') }}</th>
                                <th>{{ trans('front::messages.profile.number') }}</th>
                                <th>{{ trans('front::messages.profile.unit-price') }}</th>
                                <th>{{ trans('front::messages.profile.total-price') }}</th>
                                <th>{{ trans('front::messages.profile.discount') }}</th>
                                <th>{{ trans('front::messages.profile.final-price') }}</th>
                                <th>{{ trans('front::messages.profile.operation') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="details-product-area">
                                                @if($item->product)
                                                    <a href="{{ route('front.products.show', ['product' => $item->product]) }}"
                                                        target="_blank"><img class="thumbnail-product"
                                                            src="{{ $item->product->image ? $item->product->image : '/empty.jpg' }}"></a>
                                                @else
                                                    <img class="thumbnail-product" src="/empty.jpg">
                                                @endif

                                                <h5 class="details-product">
                                                    <span>{{ $item->title }}</span>

                                                    @if ($item->get_price)
                                                        @foreach ($item->get_price->get_attributes as $attribute)

                                                            @if ($attribute->group->type == 'color')

                                                                <span class="order-product-color" style="background-color: {{ $attribute->value }};"></span>
                                                                <span>{{ $attribute->group->name }}: {{ $attribute->name }}</span>
                                                            @else
                                                                <span>{{ $attribute->group->name }}: {{ $attribute->name }}</span>
                                                            @endif

                                                        @endforeach
                                                    @endif

                                                </h5>
                                            </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ trans('front::messages.currency.prefix') }}{{ number_format($item->realPrice()) }} {{ trans('front::messages.currency.suffix') }}</td>
                                        <td>{{ trans('front::messages.currency.prefix') }}{{ number_format($item->quantity * $item->realPrice()) }} {{ trans('front::messages.currency.suffix') }}</td>
                                        <td>{{ $item->discount ? $item->discount . '%' : 0 }}</td>
                                        <td>{{ trans('front::messages.currency.prefix') }}{{ number_format($item->price * $item->quantity) }} {{ trans('front::messages.currency.suffix') }}</td>
                                        <td>
                                            @if ($item->product && $item->product->isDownload() && $item->get_price && $item->get_price->isDownloadable())
                                                <a href="{{ $item->get_price->downloadLink() }}" class="btn btn-success mb-2">{{ trans('front::messages.profile.download') }}</a>
                                            @endif

                                            @if($item->product)
                                                <a href="{{ route('front.products.show', ['product' => $item->product]) }}" class="btn btn-info mb-2">{{ trans('front::messages.profile.view') }}</a>

                                            @else
                                                <button class="btn btn-info mb-2" disabled>{{ trans('front::messages.profile.view') }}</button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($order->transactions->count())
                    <div class="section-title text-sm-title title-wide no-after-title-wide mb-0 dt-sl px-res-1 mt-3">
                        <h2>{{ trans('front::messages.profile.payment-details') }}</h2>
                    </div>
                    <section class="checkout-details dt-sl dt-sn mb-4 pt-2 pb-3 pl-3 pr-3">
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="checkout-orders-table">
                                        <tbody>
                                            <tr>
                                                <td class="numrow">
                                                    <p>
                                                        {{ trans('front::messages.profile.row') }}
                                                    </p>
                                                </td>

                                                <td class="id">
                                                    <p>
                                                        {{ trans('front::messages.profile.transaction-number') }}
                                                    </p>
                                                </td>
                                                <td class="date">
                                                    <p>
                                                        {{ trans('front::messages.profile.history') }}
                                                    </p>
                                                </td>
                                                <td class="price">
                                                    <p>
                                                        {{ trans('front::messages.profile.amount') }}
                                                    </p>
                                                </td>
                                                <td class="status">
                                                    <p>
                                                        {{ trans('front::messages.profile.condition') }}
                                                    </p>
                                                </td>
                                            </tr>

                                            @foreach($order->transactions()->latest()->get() as $transaction)
                                                <tr>
                                                    <td class="numrow">
                                                        <p>{{ $loop->iteration }}</p>
                                                    </td>

                                                    <td class="id">
                                                        <p>{{ $transaction->id }}</p>
                                                    </td>
                                                    <td class=" date">
                                                        <p>{{ jdate($transaction->created_at)->format('%d %B %Y H:i:s') }}</p>
                                                    </td>
                                                    <td class="price">
                                                        <p>{{ trans('front::messages.currency.prefix') }} {{ number_format($transaction->amount) }} {{ trans('front::messages.currency.suffix') }}</p>
                                                    </td>
                                                    <td class="status">
                                                        <p>
                                                            @if($transaction->status)
                                                                <span class="text-success">{{ trans('front::messages.profile.successful-payment') }}</span>
                                                            @else
                                                                <span class="text-danger">{{ trans('front::messages.profile.unsuccessful-payment') }}</span>
                                                            @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                @endif
            </div>
        </div>
    </div>
    <!-- End Content -->
@endsection
