@php
    $variables      = get_widget($widget);
    $main_sliders   = $variables['fullscreen_slider'];
    $mobile_sliders = $variables['mobile_sliders'];
@endphp

<!-- Start Main-Slider -->
<div class="row index-main-slider mb-3">

    <div class="col-lg-12 col-md-12 order-1">
        <!-- Start main-slider -->
        @if ($main_sliders->count())
            <section id="main-slider" class=" main-slider main-slider-cs mt-1 carousel slide carousel-fade card hidden-sm" data-ride="carousel" style="border-radius: 0px;">
                <ol class="carousel-indicators">
                    @foreach ($main_sliders as $slider)
                        <li data-target="#main-slider" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($main_sliders as $slider)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <a class="main-slider-slide" href="{{ $slider->link }}">
                                <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" class="img-fluid">
                            </a>
                        </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev" href="#main-slider" role="button" data-slide="prev">
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <a class="carousel-control-next" href="#main-slider" data-slide="next">
                    <i class="mdi mdi-chevron-left"></i>
                </a>
            </section>
        @endif

        @if ($mobile_sliders->count())
            <section id="main-slider-res" class=" main-slider carousel slide carousel-fade card d-none show-sm" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($mobile_sliders as $slider)
                        <li data-target="#main-slider-res" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($mobile_sliders as $slider)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <a class="main-slider-slide" href="{{ $slider->link }}">
                                <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" class="img-fluid">
                            </a>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#main-slider-res" role="button" data-slide="prev">
                    <i class="mdi mdi-chevron-right"></i>
                </a>
                <a class="carousel-control-next" href="#main-slider-res" data-slide="next">
                    <i class="mdi mdi-chevron-left"></i>
                </a>
            </section>
        @endif
        <!-- End main-slider -->
    </div>
</div>
