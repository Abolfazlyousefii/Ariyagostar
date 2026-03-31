@php
    $variables              = get_widget($widget);
    $index_middle_banners   = $variables['index_middle_banners'];
@endphp

<!-- Start Banner -->
@if ($index_middle_banners->count())
<div class="row mt-3 mb-3">
    @foreach ($index_middle_banners as $banner)
        <div class="col-sm-6 col-12 mb-2">
            <div class="widget-banner">
                <a href="{{ $banner->link }}">
                    <img data-src="{{ $banner->image }}" alt="{{ $banner->title }}">
                </a>
            </div>
        </div>
    @endforeach
</div>
@endif
<!-- End Banner -->
