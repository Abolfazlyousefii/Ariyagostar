@extends('front::layouts.master')

@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            @if($cart && $cart->products()->count())

                @if(!check_cart_quantity())
                    <div class="alert alert-danger" role="alert">
                        {{ trans('front::messages.cart.product-inventory') }}<br> {{ trans('front::messages.cart.edit-shopping-cart') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span class="icon-close" aria-hidden="true"></span>
                        </button>
                    </div>
                @endif

                <div id="cart-errors" class="alert alert-danger" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span class="icon-close" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="row">

                    <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 mb-2 px-0">
                        <nav class="tab-cart-page">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ trans('front::messages.cart.cart') }}
                                    <span class="count-cart">{{ $cart->quantity }}</span>
                                </a>
                            </div>
                        </nav>
                    </div>
                    <div class="col-12">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-8 col-12">
                                        <div class="row">
                                            <div class="col-md-12 px-0">
                                                <div class="table-responsive checkout-content dt-sl">
                                                    <div class="checkout-header checkout-header--express">
                                                        <span class="checkout-header-title">({{ $cart->products->count() }} {{ trans('front::messages.cart.kala') }})</span>
                                                    </div>

                                                    <div class="container-fluid shop-list">
                                                        <form id="cart-update-form" action="{{ route('front.cart') }}" method="POST">
                                                            @method('put')
                                                            @csrf

                                                            @foreach($cart->products as $product)

                                                                @php
                                                                    $price_to_stock = $product->prices()->find($product->pivot->price_id);
                                                                    $has_stock = $price_to_stock->hasStock($product->pivot->quantity);
                                                                @endphp

                                                                <div class="row list-row">
                                                                    <div class="col-4 col-sm-3 col-md-2">
                                                                        <a href="{{ route('front.products.show', ['product' => $product]) }}">
                                                                            <img class="img-fluid p-2" src="{{ $product->image ? asset($product->image) : asset('empty.jpg') }}" alt="{{ $product->title }}">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-8 col-sm-9 col-md-5 card-product-name">
                                                                        <a href="{{ route('front.products.show', ['product' => $product]) }}">
                                                                            <h3 class="title">{{ $product->title }}</h3>
                                                                        </a>

                                                                        @if ($product->isPhysical())
                                                                            @foreach ($price_to_stock->get_attributes as $attribute)
                                                                                <p class="detail">{{ $attribute->group->name }} : {{ $attribute->name }}</p>
                                                                            @endforeach
                                                                        @else
                                                                            <p class="detail">{{ $price_to_stock->file->title }}</p>
                                                                        @endif

                                                                        @if (!$has_stock['status'])
                                                                            <small class="text-danger">{{ $has_stock['message'] }}</small>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-4 col-sm-3 col-md-2 d-flex justify-content-center">

                                                                        <div class="counter-box">
                                                                            <button type="button" class="inc"><i class="mdi mdi-plus"></i></button>
                                                                            <input class="quantity cart_quantity count" min="{{ cart_min($price_to_stock) }}" name="product-{{ $product->pivot->id }}" max="{{ cart_max($price_to_stock) }}" value="{{ $product->pivot->quantity }}" type="number" data-minus-class="mdi mdi-minus" data-remove-class="mdi mdi-delete-outline" required>
                                                                            <button type="button" data-action="{{ route('front.cart.destroy', ['id' => $product->pivot->id]) }}" class="dec">
                                                                                <i class="mdi mdi-minus"></i>
                                                                            </button>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-8 col-sm-9 col-md-3">
                                                                        <strong class="cart-product-price"><span class="currency-suffix">{{ trans('front::messages.currency.prefix') }}</span>{{ number_format($price_to_stock->salePrice() * $product->pivot->quantity) }} <span class="currency-suffix">{{ trans('front::messages.currency.suffix') }}</span></strong>

                                                                        @if($price_to_stock->hasDiscount())
                                                                            <del class="text-danger old-cart-c"><span class="currency-suffix">{{ trans('front::messages.currency.prefix') }}</span>{{ number_format($price_to_stock->regularPrice() * $product->pivot->quantity) }} <span class="currency-suffix">{{ trans('front::messages.currency.suffix') }}</span></del>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2 p-md-0">
                                                <div class="text-left">
                                                    <button id="update-cart" data-action="{{ route('front.cart') }}" data-redirect="{{ route('front.cart') }}" type="button" class="btn btn-light">{{ trans('front::messages.cart.shopping-cart-update') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @include('front::partials.checkout-sidebar')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="dt sl dt-sn pt-3 pb-5">
                            <div class="cart-page cart-empty">
                                <div class="circle-box-icon">
                                    <i class="mdi mdi-cart-remove"></i>
                                </div>
                                <p class="cart-empty-title">{{ trans('front::messages.cart.your-cart-empty') }}</p>
                                <p class="pb-3">{{ trans('front::messages.cart.you-more-products') }}</p>

                                <a href="/" class="btn-primary-cm">{{ trans('front::messages.cart.go-to-the-main-page') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>
    <!-- End main-content -->

    <!-- Start Modal location new -->
    <div class="modal fade" id="delete-modal" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        <i class="now-ui-icons location_pin"></i>
                        {{ trans('front::messages.cart.remove-product') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('front::messages.cart.remove-product-cart') }}</p>

                    <div class="form-ui dt-sl p-0">
                        <form id="delete-form" class="text-center p-0" action="#" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-md">{{ trans('front::messages.cart.yes-delete') }}</button>
                            <button class="btn btn-light" data-dismiss="modal">{{ trans('front::messages.cart.cancellation') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal location new -->

@endsection

@push('scripts')
    <script src="{{ theme_asset('js/pages/cart.js') }}?v=3"></script>
@endpush
