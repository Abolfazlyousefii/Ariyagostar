@php
    $cart = isset($render_cart) ? $render_cart : $cart;
@endphp

@if($cart && $cart->products()->count())
    <li class="nav-item" id="cart-list-item">
        <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
            <span class="label-dropdown">{{ trans('front::messages.header.cart') }}</span>
            <i class="mdi mdi-cart-outline"></i>
            <span class="count">{{ $cart->quantity }}</span>
        </a>
        <div class="dropdown-menu cart dropdown-menu-sm dropdown-menu-left">
            <div class="dropdown-header">{{ trans('front::messages.header.cart') }}</div>
            <div class="dropdown-list-icons">

                @foreach ($cart->products as $product)
                    <a href="{{ route('front.products.show', ['product' => $product]) }}" class="dropdown-item">
                        <div class="dropdown-item-icon">
                            <img src="{{ $product->image ? $product->image : '/empty.jpg' }}" alt="{{ $product->title }}">
                        </div>
                        <div class="mr-3 cart-title">
                            {{ $product->title }}

                                @php
                                    $cart_product_price = $product->prices()->find($product->pivot->price_id);
                                @endphp

                                <div class="pt-1">{{ trans('front::messages.currency.prefix') }}{{ number_format($cart_product_price->salePrice() * $product->pivot->quantity) }} {{ trans('front::messages.currency.suffix') }}</div>
                                @if($cart_product_price->hasDiscount())
                                    <del class="text-danger">{{ trans('front::messages.currency.prefix') }}{{ number_format($cart_product_price->regularPrice() * $product->pivot->quantity) }} {{ trans('front::messages.currency.suffix') }}</del>
                                @endif

                        </div>
                    </a>
                @endforeach
            </div>
            <hr>
            <div class="dropdown-footer text-center">
                <div class="dt-sl mb-3">
                    <span class="float-right">{{ trans('front::messages.header.total') }}</span>
                    <span class="float-left">{{ trans('front::messages.currency.prefix') }}{{ number_format($cart->discountPrice()) }} {{ trans('front::messages.currency.suffix') }}</span>
                </div>
                <a href="{{ route('front.cart') }}" class="btn btn-success">{{ trans('front::messages.header.view-cart') }}</a>
                <a href="{{ route('front.checkout') }}" class="btn btn-primary">{{ trans('front::messages.header.payment') }}</a>
            </div>
        </div>
    </li>

@else

    <li class="nav-item" id="cart-list-item">
        <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
            <span class="label-dropdown">{{ trans('front::messages.header.cart') }}</span>
            <i class="mdi mdi-cart-outline"></i>
        </a>
        <div class="dropdown-menu cart dropdown-menu-sm dropdown-menu-left text-center">
            <p class="pt-2">{{ trans('front::messages.header.shopping-cart-empty') }}</p>
        </div>
    </li>

@endif
