<div class="item">
    <div class="product-card">
        <div class="product-head">
            @if ($product->labels->count())
                <div class="row">
                    <div class="btn-group" role="group">
                        @foreach ($product->labels as $label)
                            <div class="fild_products">
                                <span>{{ $label->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($product->discount)
                <div class="discount">
                    <span>{{ $product->discount }} %</span>
                </div>
            @endif

        </div>
        <a class="product-thumb" href="{{ route('front.products.show', ['product' => $product]) }}">
            <img data-src="{{ $product->image ? asset($product->image) : asset('/no-image-product.png') }}" src="{{ theme_asset('images/600-600.png') }}" alt="{{ $product->title }}">
        </a>
        <div class="product-card-body">

            <h5 class="product-title">
                <a href="{{ route('front.products.show', ['product' => $product]) }}" title="{{ $product->title }}">{{ $product->title }}</a>
            </h5>
            <div class="rating-stars">
                <a class="product-meta" href="{{ $product->category ? $product->category->link : '#' }}">{{ $product->category ? $product->category->title : trans('front::messages.partials.no-category') }}</a>
                @if ($product->rating)
                    <span class="mx-3 float-left">{{ $product->rating }}<i class="mr-1 mdi mdi-star active"></i></span>
                @endif
            </div>
            <div class="price-index-h">
                <div class="product-prices-div">
                    <span class="product-price">{{ $product->getLowestPrice() }}</span>

                    @if ($product->getLowestDiscount())
                        <del class="product-price-del">{{ $product->getLowestDiscount() }}</del>
                    @endif
                </div>
            </div>

            @if ($product->isSinglePrice())
                <div class="cart">
                    <a data-action="{{ route('front.cart.store', ['product' => $product]) }}" class="d-flex align-items-center add-to-cart-single" href="javascript:void(0)"><i class="mdi mdi-plus px-2"></i>
                        <span>{{ trans('front::messages.partials.add-to-cart') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
