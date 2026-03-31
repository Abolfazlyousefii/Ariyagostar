@php
    $variables      = get_widget($widget);
    $products       = $variables['products'];
@endphp

<!-- Start special products -->
@if ($products->count())
    <section class="slider-section mb-3 amazing-section" style="background: {{ $widget->option('block_color', '#ef394e') }}">
        <div class="container main-container">
            <div class="row mb-3">

                <div class="col-lg-12 col-xs-12">
                    <div class="product-carousel carousel-lg owl-carousel owl-theme">
                        @if ($widget->option('link') || $widget->option('image'))
                            <div class="item">
                                <div class="amazing-product text-center pt-5">
                                    @if ($widget->option('image'))
                                        <a href="{{ $widget->option('link') }}">
                                            <img src="{{ $widget->option('image') }}" alt="pecial products">
                                        </a>
                                    @endif

                                    @if ($widget->option('link'))
                                        <a href="{{ $widget->option('link') }}" class="view-all-amazing-btn">
                                            {{ $widget->option('link_title', trans('front::messages.user.see-all')) }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @foreach ($products as $product)
                            @include('front::partials.product-block-2')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- End special products -->
