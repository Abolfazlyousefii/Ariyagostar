@php
    $variables    = get_widget($widget);
    $categories   = $variables['categories'];
@endphp

<!-- Start Category-Section -->
@if ($categories->count())
<div class="row mt-3 mb-3">
    <div class="col-12">
        <div class="category-section dt-sn dt-sl">
            <div class="category-section-title dt-sl">
                <h3>{{ trans('front::messages.index.products-categorization') }}</h3>
            </div>
            <div class="category-section-slider dt-sl">
                <div class="category-slider owl-carousel">
                    @foreach ($categories as $category)
                        <div class="item">
                            <a href="{{ $category->link }}" class="promotion-category">
                                <img data-src="{{ $category->image ? asset($category->image) : asset('no-image-product.png') }}" alt="{{ $category->title }}">
                                <h4 class="promotion-category-name">{{ $category->title }}</h4>
                                <h6 class="promotion-category-quantity">{{ $category->allPublishedProducts()->count() }}{{ trans('front::messages.header.kala') }}</h6>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- End Category-Section -->
