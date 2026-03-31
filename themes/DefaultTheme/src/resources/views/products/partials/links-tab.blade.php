<div class="ah-tab-content dt-sl">
    <div class="section-title text-sm-title title-wide no-after-title-wide mb-0 dt-sl">
        <h2>{{ trans('front::messages.products.product-files') }}</h2>
    </div>

    <input id="cart-quantity" class="quantity" value="1" type="hidden">

    <div class="description-product dt-sl mt-3 mb-3">
        <div class="container-fluid">
            @foreach ($product->prices()->whereHas('file')->orderBy('prices.ordering')->get() as $price)
                <div class="row files mb-2">
                    <div class="col-md-1 col-2"><span class="mdi mdi-lock"></span></div>
                    <div class="col-md-2 col-5">
                        <p class="m-0">{{ $price->file->title }}</p>
                    </div>
                    <div class="col-md-2 col-5">
                        <p class="mb-0">{{ trans('front::messages.currency.prefix') }}{{ number_format($price->salePrice()) }} {{ trans('front::messages.currency.suffix') }}</p>

                        @if ($price->hasDiscount())
                            <del class="text-danger">{{ trans('front::messages.currency.prefix') }}{{ number_format($price->regularPrice()) }} {{ trans('front::messages.currency.suffix') }}</del>
                        @endif
                    </div>
                    <div class="col-md-3 col-6 ltr text-center">
                        <span>{{ formatSizeUnits($price->file->size) }}</span>
                    </div>
                    <div class="col-md-4 col-6">

                        @if ($price->isDownloadable())

                            @if (auth()->check())
                                <a href="{{ $price->downloadLink() }}" class="btn btn-success">
                                    {{ trans('front::messages.products.download') }}
                                </a>
                            @else
                                <a href="{{ route('login', ['redirect' => route('front.products.show', ['product' => $product])]) }}" class="btn btn-success">
                                    {{ trans('front::messages.products.login-and-download') }}
                                </a>
                            @endif

                        @else
                            <button data-price_id="{{ $price->id }}" data-action="{{ route('front.cart.store', ['product' => $product]) }}" data-product="{{ $product->slug }}" type="button" class="btn btn-primary add-to-cart">
                                {{ trans('front::messages.products.add-to-cart') }}
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
