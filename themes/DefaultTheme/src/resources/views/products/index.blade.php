@extends('front::layouts.master', ['title' => trans('front::messages.products.products')])

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
@endpush

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 search-card-res">
                    <div class="title-breadcrumb-special dt-sl mb-3">
                        <div class="breadcrumb dt-sl">
                            <nav>
                                <a href="/">{{ trans('front::messages.products.home') }}</a>
                                <span>{{ trans('front::messages.products.products') }}</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <aside class="col-lg-3 col-md-12 col-sm-12 sticky-sidebar mb-3">
                    <div class="dt-sn p-3">
                        <button class="btn btn-light btn-block d-lg-none mb-3" type="button" data-toggle="collapse" data-target="#products-filters-collapse" aria-expanded="false" aria-controls="products-filters-collapse">
                            {{ trans('front::messages.categories.product-filters') }}
                        </button>

                        <div class="collapse d-lg-block" id="products-filters-collapse">
                            <form action="{{ route('front.products.index') }}" method="GET">
                                <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide">
                                    <h2>{{ trans('front::messages.categories.product-filters') }}</h2>
                                </div>

                                <div class="form-group">
                                    <label for="filter-s">{{ trans('front::messages.categories.search-products') }}</label>
                                    <input id="filter-s" type="text" class="form-control" name="s" value="{{ request('s') }}" placeholder="{{ trans('front::messages.categories.enter-name-product') }}">
                                </div>

                                <div class="form-group">
                                    <label for="filter-category">{{ trans('front::messages.categories.grouping') }}</label>
                                    <select id="filter-category" name="category_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">{{ trans('front::messages.categories.all-categories') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (int) request('category_id') === (int) $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="filter-sub-category">{{ trans('front::messages.categories.sub-category') }}</label>
                                    <select id="filter-sub-category" name="child_category_id" class="form-control">
                                        <option value="">{{ trans('front::messages.categories.all-sub-categories') }}</option>
                                        @foreach($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" {{ (int) request('child_category_id') === (int) $subCategory->id ? 'selected' : '' }}>{{ $subCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="filter-brand">{{ trans('front::messages.categories.brand') }}</label>
                                    <select id="filter-brand" name="brand_id" class="form-control">
                                        <option value="">{{ trans('front::messages.categories.all-brands') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ (int) request('brand_id') === (int) $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="filter-min-price">{{ trans('front::messages.categories.min-price') }}</label>
                                        <input id="filter-min-price" type="number" class="form-control" name="min_price" min="0" value="{{ request('min_price') }}" placeholder="{{ $priceRange?->min_price ? (int) $priceRange->min_price : 0 }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="filter-max-price">{{ trans('front::messages.categories.max-price') }}</label>
                                        <input id="filter-max-price" type="number" class="form-control" name="max_price" min="0" value="{{ request('max_price') }}" placeholder="{{ $priceRange?->max_price ? (int) $priceRange->max_price : 0 }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="filter-stock">{{ trans('front::messages.categories.stock-status') }}</label>
                                    <select id="filter-stock" name="stock_status" class="form-control">
                                        <option value="">{{ trans('front::messages.categories.all-products') }}</option>
                                        <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>{{ trans('front::messages.categories.only-available-goods') }}</option>
                                        <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>{{ trans('front::messages.categories.only-unavailable-goods') }}</option>
                                    </select>
                                </div>

                                <div class="form-group custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="discounted-check" name="discounted" value="1" {{ request()->boolean('discounted') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="discounted-check">{{ trans('front::messages.categories.discounted-only') }}</label>
                                </div>

                                <div class="form-group">
                                    <label for="sort-type">{{ trans('front::messages.categories.sort-by') }}</label>
                                    <select id="sort-type" name="sort_type" class="form-control">
                                        <option value="latest" {{ request('sort_type', 'latest') === 'latest' ? 'selected' : '' }}>{{ trans('front::messages.categories.the-newest') }}</option>
                                        <option value="cheapest" {{ request('sort_type') === 'cheapest' ? 'selected' : '' }}>{{ trans('front::messages.categories.cheapest') }}</option>
                                        <option value="expensivest" {{ request('sort_type') === 'expensivest' ? 'selected' : '' }}>{{ trans('front::messages.categories.most-expensive') }}</option>
                                        <option value="sale" {{ request('sort_type') === 'sale' ? 'selected' : '' }}>{{ trans('front::messages.categories.bestselling') }}</option>
                                        <option value="view" {{ request('sort_type') === 'view' ? 'selected' : '' }}>{{ trans('front::messages.categories.the-most-visited') }}</option>
                                    </select>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-info btn-block" type="submit">{{ trans('front::messages.categories.filter') }}</button>
                                    <a class="btn btn-outline-secondary btn-block mr-2" href="{{ route('front.products.index') }}">{{ trans('front::messages.categories.clear-filters') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>

                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="dt-sn p-3 mb-3">
                        <h1 class="mb-1 product-index-title">{{ trans('front::messages.products.products') }}</h1>
                        <p class="text-muted mb-0">{{ trans('front::messages.categories.products-count', ['count' => $products->total()]) }}</p>
                    </div>

                    @if($products->count())
                        <div class="dt-sl dt-sn px-0 search-amazing-tab mt-3">
                            <div class="row mb-3 mx-0 px-res-0">
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 px-10 mb-1 px-res-0 category-product-div">
                                        @include('front::products.partials.product-card', ['product' => $product])
                                    </div>
                                @endforeach
                            </div>

                            {{ $products->links('front::components.paginate') }}
                        </div>
                    @else
                        @include('front::partials.empty')
                    @endif
                </div>
            </div>

        </div>
    </main>
    <!-- End main-content -->

@endsection
