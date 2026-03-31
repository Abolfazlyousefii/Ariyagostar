@php
    $variables          = get_widget($widget);
    $sevices_sliders    = $variables['sevices_sliders'];
@endphp

<!-- services -->
@if ($sevices_sliders->count())
    <div class="bk-icons-footer mb-3">
        <div class="footer-services">
            <div class="row">
                @foreach ($sevices_sliders as $slider)
                    <div class="service-item col">
                        <a href="{{ $slider->link }}">
                            <img data-src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                        </a>
                        <p>{{ $slider->title }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
<!-- End services -->
