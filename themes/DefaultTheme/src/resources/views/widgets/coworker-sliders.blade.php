@php
    $variables = get_widget($widget);
    $coworker_sliders = $variables['coworker_sliders'];
@endphp


<!-- Start Partners -->
@if ($coworker_sliders->count())
    <section class="slider-section dt-sl mb-3">
        <div class="row">
            <div class="col-12">
                <div class="brand-slider carousel-sm owl-carousel owl-theme">
                    @foreach ($coworker_sliders as $slider)
                        <div class="item">
                            <a href="{{ $slider->link }}">
                                <img data-src="{{ $slider->image }}" class="img-fluid" alt="{{ $slider->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
<!-- End Partners -->
