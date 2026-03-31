@php
    $variables      = get_widget($widget);
    $products       = $variables['products'];
@endphp

<!-- Start products -->
@if ($products->count())
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <section class="slider-section dt-sl mb-3">
                <div class="row mb-3">
                    <div class="col-12 px-0 px-sm-3">
                        <div class="section-title text-sm-title title-wide-custom title-wide no-after-title-wide">
                            <h2>{{ $widget->option('title') }}</h2>
                            @if ($widget->option('link'))
                                <a href="{{ $widget->option('link') }}">{{ $widget->option('link_title', trans('front::messages.user.see-all')) }} ></a>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 px-res-0">
                        <div class="product-carousel carousel-md owl-carousel owl-theme">
                            @foreach ($products as $product)
                                @include('front::partials.product-block')
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endif
<!-- End products -->
