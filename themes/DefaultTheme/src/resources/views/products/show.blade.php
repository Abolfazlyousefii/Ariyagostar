@extends('front::layouts.master', ['title' => $product->meta_title ?: $product->title])

@push('meta')
    @if(option('allow_indexing_product_page') == "off")
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">

    @else
    <meta name="robots" content="index, follow"/>
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    @endif
    <meta name="description" content="{{ option('info_short_description') }}">
    <meta name="keywords" content="{{ option('info_tags') }}">
    <link rel="canonical" href="{{ route('front.products.index') }}" />
    @include('front::products.partials.product-meta')
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/fancybox.min.css') }}">
@endpush

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">
            <!-- Start title - breadcrumb -->
            <div class="title-breadcrumb-special dt-sl mb-3">
                <div class="breadcrumb dt-sl">
                    <nav>
                        <a href="{{ route('front.index') }}">{{ trans('front::messages.products.home') }}</a>
                        <a href="{{ route('front.products.index') }}">{{ trans('front::messages.products.products') }}</a>
                        @if ($product->category)

                            @foreach ($product->category->parents() as $parent)
                                <a href="{{ route('front.products.category', ['category' => $parent]) }}">{{ $parent->title }}</a>
                            @endforeach

                            <a href="{{ route('front.products.category', ['category' => $product->category]) }}">{{ $product->category->title }}</a>

                        @endif
                        <span>{{ $product->title }}</span>
                    </nav>
                </div>
            </div>
            <!-- End title - breadcrumb -->

            <!-- Start Product -->
            <div class="dt-sn mb-3 dt-sl">
                <div class="row">
                    <!-- Product Gallery-->
                    <div class="col-lg-4 col-md-12 ps-relative">
                        @if(!$product->addableToCart())
                            <div class="product-timeout position-relative pt-5 mb-4">
                                <div class="promotion-badge not-available">
                                    {{ trans('front::messages.products.unavailable') }}
                                </div>
                            </div>
                        @elseif($product->isSpecial())

                            <div class="product-timeout position-relative pt-5 mb-4">
                                <div class="promotion-badge">
                                    <div class="product-special">
                                        {{ trans('front::messages.products.special-sale') }}
                                    </div>
                                </div>
                                @if ($product->special_end_date)
                                    <div id="product-special-end-date" class="countdown-timer mt-4" countdown data-date="{{ $product->special_end_date->format('D M d Y H:i:s O') }}">
                                        <span data-days="">0</span>:
                                        <span data-hours="">0</span>:
                                        <span data-minutes="">0</span>:
                                        <span data-seconds="">0</span>
                                    </div>
                                @endif
                            </div>

                        @endif

                        <ul class="gallery-options {{ $product->isSpecial() ? 'special' : '' }}">
                            @if (auth()->check())
                                @php
                                    $favorite_product = auth()->user()->favorites()->where('product_id', $product->id)->first();
                                @endphp
                                <li>
                                    <button id="add-to-favorites" data-action="{{ route('front.favorites.store') }}" data-product="{{ $product->id }}" class="add-favorites {{ $favorite_product ? 'favorites' : '' }}"><i class="mdi mdi-heart"></i></button>
                                    @if ($favorite_product)
                                        <span class="tooltip-option">  {{ trans('front::messages.products.remove-from-favorites') }} </span>
                                    @else
                                        <span class="tooltip-option">{{ trans('front::messages.products.add-to-favorites') }}</span>
                                    @endif
                                </li>
                            @endif

                            @if ($similar_products_count)
                                <a href="{{ route('front.products.compare', ['product1' => $product->id]) }}">
                                    <li>
                                        <button class="add-favorites"><i class="mdi mdi-compare"></i></button>
                                        <span class="tooltip-option">{{ trans('front::messages.products.comparison') }}</span>
                                    </li>
                                </a>
                            @endif

                            @if ($show_prices_chart)
                                <li>
                                    <button data-toggle="modal" data-target="#price-changes-modal"><i class="mdi mdi-chart-line"></i></button>
                                    <span class="tooltip-option">{{ trans('front::messages.products.price-chart') }}</span>
                                </li>
                            @endif

                            @if (option('show_product_share_links', 1) == 1)
                                <li>
                                    <button data-toggle="modal" data-target="#shareproduct"><i class="mdi mdi-share-variant"></i></button>
                                    <span class="tooltip-option">اشتراک گذاری</span>
                                </li>
                            @endif

                            @can('products.update')
                                <li>
                                    <a href="{{ route('admin.products.edit', ['product' => $product]) }}" target="_blank">
                                        <button><i class="mdi mdi-pencil text-warning"></i></button>
                                    </a>
                                    <span class="tooltip-option">{{ trans('front::messages.products.edit') }}</span>
                                </li>
                            @endcan

                        </ul>

                        @if($product->gallery()->count())
                            <div id="product-gallery" class="product-gallery mt-3">
                                <div class="product-carousel main-gallery owl-carousel">
                                    @foreach ($product->gallery()->orderBy('ordering')->get() as $item)
                                        <div class="item gallery-image-item" data-color-id="{{ $item->color_id }}">
                                            <a class="gallery-item mt-3" href="{{ asset($item->image) }}" data-fancybox="gallery" data-owl="one{{ $loop->index }}">
                                                <img src="{{ theme_asset('images/600-600.png') }}" data-src="{{ asset($item->image) }}" alt="{{ $product->title }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="border-product"/>
                                <ul class="product-thumbnails product-carousel owl-carousel carousel-products">
                                    @foreach ($product->gallery()->orderBy('ordering')->get() as $item)
                                        <li class="{{ ($loop->index == 0) ? 'active' : '' }} gallery-image-item" data-color-id="{{ $item->color_id }}" data-image="{{ asset($item->image) }}">
                                            <a href="#one{{ $loop->index }}" class="owl-thumbnail" data-slide="{{ $loop->index }}">
                                                <img src="{{ theme_asset('images/600-600.png') }}" data-src="{{ asset($item->image) }}" alt="{{ $product->title }}">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                    @include('front::products.partials.product-info')
                </div>
            </div>
            <div class="dt-sn mb-3 px-0 dt-sl pt-0">
                <!-- Start tabs -->
                <section class="tabs-product-info mb-3 dt-sl">
                    <div class="ah-tab-wrapper dt-sl">
                        <div class="ah-tab dt-sl">
                            @if ($product->isDownload())
                                <a class="ah-tab-item" href="javascript:void(0)"><i class="mdi mdi-download"></i>{{ trans('front::messages.products.product-files') }}</a>
                            @endif

                            @if ($product->description)
                                <a class="ah-tab-item" href="javascript:void(0)"><i class="mdi mdi-glasses"></i>{{ trans('front::messages.products.general-specifications') }}</a>
                            @endif

                            @if ($product->specificationGroups()->count())
                                <a class="ah-tab-item" href="javascript:void(0)"><i class="mdi mdi-format-list-checks"></i>{{ trans('front::messages.products.technical-specifications') }}</a>
                            @endif

                            <a class="ah-tab-item" href="javascript:void(0)"><i class="mdi mdi-comment-text-multiple-outline"></i>{{ trans('front::messages.products.comment') }}</a>

                            <a class="ah-tab-item" href="javascript:void(0)"><i class="mdi mdi-comment-question-outline"></i>{{ trans('front::messages.products.comments-questions-answers') }}</a>
                        </div>
                    </div>
                    <div class="ah-tab-content-wrapper product-info px-4 dt-sl">
                        @if ($product->isDownload())
                            @include('front::products.partials.links-tab')
                        @endif

                        @if ($product->description)
                            <div class="ah-tab-content dt-sl">
                                <div class="section-title text-sm-title title-wide no-after-title-wide mb-0 dt-sl">
                                    <h2>{{ trans('front::messages.products.general-specifications') }}</h2>
                                </div>

                                <div class="description-product dt-sl mt-3 mb-3">
                                    <div class="container">
                                        <p>{!! $product->description !!}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($product->specificationGroups()->count())
                            <div class="ah-tab-content params dt-sl">
                                <div class="section-title text-sm-title title-wide no-after-title-wide mb-0 dt-sl">
                                    <h2>{{ trans('front::messages.products.technical-specifications') }}</h2>
                                </div>
                                @foreach($product->specificationGroups->unique() as $group)
                                    <section>
                                        <h3 class="params-title">{{ $group->name }}</h3>
                                        <ul class="params-list">
                                            @foreach($product->specifications()->where('specification_group_id', $group->id)->get() as $specification)
                                                <li>
                                                    <div class="params-list-key">
                                                        <span class="d-block">{{ $specification->name }}</span>
                                                    </div>
                                                    <div class="params-list-value">
                                                            <span class="d-block">
                                                                {!! nl2br(htmlentities($specification->pivot->value)) !!}
                                                            </span>
                                                    </div>

                                                </li>
                                            @endforeach
                                        </ul>
                                    </section>
                                @endforeach
                            </div>
                        @endif

                        @include('front::products.partials.reviews')

                        <div class="ah-tab-content dt-sl">
                            @include('front::components.comments', ['model' => $product, 'route_link' => route('front.product.comments', ['product' => $product]), 'message' => trans('front::messages.products.no-comments') ])
                        </div>
                    </div>
                </section>
                <!-- End tabs -->
            </div>
            <!-- End Product -->

            @if($related_products->count())
                <!-- Start Product-Slider -->
                <section class="slider-section dt-sl">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="section-title text-sm-title title-wide no-after-title-wide">
                                <h2>{{ trans('front::messages.products.related-products') }}</h2>
                            </div>
                        </div>

                        <!-- Start Product-Slider -->
                        <div class="col-12">
                            <div class="product-carousel carousel-lg owl-carousel owl-theme">
                                @foreach ($related_products as $related_product)
                                    @include('front::partials.product-block', ['product' => $related_product])
                                @endforeach
                            </div>

                        </div>
                        <!-- End Product-Slider -->

                    </div>
                </section>
                <!-- End Product-Slider -->
            @endif

        </div>
    </main>
    <!-- End main-content -->


    @if(!$product->addableToCart())
        <!-- Start Modal stocknotify -->
        <div class="modal fade" id="modal-stock-notify" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-md send-info modal-dialog-centered"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">
                            <i class="now-ui-icons location_pin"></i>
                            {{ trans('front::messages.products.inventory-information') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-ui dt-sl">
                                    <form class="form-account" action="#">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 mb-2">
                                                <div class="form-row-title">
                                                    <h4>
                                                        {{ trans('front::messages.products.fname-and-lname') }} </h4>
                                                </div>
                                                <div class="form-row">
                                                    <input class="input-ui pr-2 text-right"
                                                        type="text"
                                                        name="name"
                                                        id="stock-name"
                                                        placeholder=" {{ trans('front::messages.products.enter-your-name') }} " required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-2">
                                                <div class="form-row-title">
                                                    <h4>
                                                        {{ trans('front::messages.products.phone-number') }}
                                                    </h4>
                                                </div>
                                                <div class="form-row">
                                                    <input
                                                        class="input-ui pl-2 dir-ltr text-left"
                                                        type="text"
                                                        name="mobile"
                                                        id="stock-mobile"
                                                        placeholder="09xxxxxxxxx" required>
                                                </div>
                                            </div>

                                            <div class="col-12 pr-4 pl-4 text-center">
                                                <button id="sendStockNotifyBtn" type="button" class="btn btn-md btn-primary btn-submit-form" data-dismiss="modal">{{ trans('front::messages.products.let-me-know') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal stocknotify -->
    @endif

    @if ($show_prices_chart)
        <!-- Modal -->
        <div class="modal fade" id="price-changes-modal" tabindex="-1" aria-labelledby="price-changes-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pb-0">
                        <h5 class="modal-title" id="price-changes-modal-label">{{ trans('front::messages.products.sales-price-chart') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body chart-area">
                        <strong class="text-muted">{{ $product->title }}</strong>
                        <p class="mt-1 text-muted" id="selected-chart-price-title"></p>
                        <div>
                            <div id="empty-chart" class="empty-chart" style="display: none">
                                <p>{{ trans('front::messages.products.thirty-day-change') }}</p>
                            </div>
                            <div id="chart" class="ltr"></div>
                        </div>
                        <ul class="chart-prices-label">
                            @foreach ($product->prices()->orderBy('stock', 'desc')->get() as $chart_price)
                                @php
                                    $label = $chart_price->getAttributesName();
                                @endphp
                                <li>
                                    <label data-action="{{ route('front.products.priceChart', ['price' => $chart_price]) }}" data-title="{{ $chart_price->getAttributesName() }}" title="{{ $chart_price->getAttributesName() }}">
                                        <span>{{ $label != '' ? $label : $product->title }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (option('show_product_share_links', 1) == 1)
        <!-- Modal -->
        <div class="modal fade" id="shareproduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">اشتراک گذاری</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">



                    <div><p>با استفاده از روش‌های زیر می‌توانید این صفحه را با دوستان خود به اشتراک بگذارید.</p></div>
                    <ul class="share-product">

                        <a target="_blank" class="telegram" href="https://t.me/share/url?url={{ route('front.products.shortLink', ['id' => $product->id]) }}">
                            <li  class="custom-mdi mdi mdi-telegram"></li>
                        </a>

                        <a target="_blank" class="whatsapp" href="https://api.whatsapp.com/send?text={{ route('front.products.shortLink', ['id' => $product->id]) }}">
                            <li  class="custom-mdi mdi mdi-whatsapp"></li>
                        </a>
                        <a target="_blank" class="twiiter" href="https://twitter.com/intent/tweet?url={{ route('front.products.shortLink', ['id' => $product->id]) }}">
                            <li  class="custom-mdi mdi mdi-twitter"></li>
                        </a>
                        <a target="_blank" class="linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url= {{route('front.products.shortLink', ['id' => $product->id]) }}">
                            <li  class="custom-mdi mdi mdi-linkedin"></li>
                        </a>
                    </ul>
                    <hr>
                    <div class="filed-link dir-ltr copy-text">

                        <input id="shareLink" type="text" disabled value="{{ route('front.products.shortLink', ['id' => $product->id]) }}" readonly="">

                        <div class="copy-text-btn" data-toggle="tooltip" data-placement="right" title="" data-original-title="کپی لینک">
                            <i class="mdi mdi-content-copy"></i>
                        </div>
                    </div>
                </div>

              </div>
            </div>
        </div>
    @endif

    <!-- product review add modal -->
    @if (auth()->check())
        @include('front::products.partials.add-review')
    @endif
    <!-- product review add modal -->

    @include('front::products.partials.sizes-modal')
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/vendor/jquery.fancybox.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ theme_asset('js/pages/products/show.js') }}?v=21"></script>
    <script src="{{ theme_asset('js/pages/comments.js') }}"></script>
@endpush
