<div class="product-card mb-2 mx-res-0">
    @if ($product->isSpecial())
        <div class="promotion-badge text-right">
            {{ trans('front::messages.categories.special-sale') }}
        </div>
    @endif
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
                <span>{{ $product->discount }}%</span>
            </div>
        @endif
    </div>
    <a class="product-thumb" href="{{ route('front.products.show', ['product' => $product]) }}"
       style="padding: 0 !important;">
        <img data-src="{{ $product->image ? asset($product->image) : asset('/no-image-product.png') }}"
             src="{{ theme_asset('images/600-600.png') }}" alt="{{ $product->title }}"
             style="width: 100%;
             height: 100%;
             object-fit: cover;">

    </a>
    <div class="product-card-body">

        <h5 class="product-title special-title" style="border-bottom: 1px solid #989898;">
            <a href="{{ route('front.products.show', ['product' => $product]) }}">{{ $product->title }}</a>
        </h5>

        @if ($product->category)
            <a class="product-meta"
               href="{{ route('front.products.category', ['category' => $product->category]) }}">{{ $product->category->title }}</a>
        @endif
        <div class="rating-stars">
            @for ($product->rating; $product->rating > 0; $product->rating--)
                <i class="mdi mdi-star active"></i>
            @endfor
        </div>

        <div class="product-prices-div">
            <span class="product-price text-left">{{ $product->getLowestPrice() }}</span>

            @if ($product->getLowestDiscount())
                <del class="product-price text-danger text-left">{{ $product->getLowestDiscount() }}</del>
            @endif
        </div>

        @if ($product->isSinglePrice())
            <div class="cart">
                <a data-action="{{ route('front.cart.store', ['product' => $product]) }}"
                   class="d-flex align-items-center add-to-cart-single" href="javascript:void(0)"><i
                        class="mdi mdi-plus px-2"></i>
                    <span>{{ trans('front::messages.categories.add-to-cart') }}</span>
                </a>
            </div>
        @endif

    </div>
</div>
