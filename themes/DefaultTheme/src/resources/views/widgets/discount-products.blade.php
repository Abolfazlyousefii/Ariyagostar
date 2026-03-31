@php
    $variables = get_widget($widget);
    $products = $variables['products'];
    $timer = $variables['timer'];
@endphp

<!-- Start products -->
@if ($products->count())
    <div class="discount-timer">
        <span data-timer="{{ $timer }}" class="timer"></span>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <section class="slider-section dt-sl mb-3">
                <div class="row mb-3">
                    <div class="col-12 px-0 px-sm-3">
                        <div class="section-title text-sm-title title-wide-custom title-wide no-after-title-wide">
                            <h2>{{ $widget->option('title') }}</h2>
                            @if ($widget->option('link'))
                                <a href="{{ $widget->option('link') }}">{{ $widget->option('link_title', trans('front::messages.user.see-all')) }}
                                    ></a>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            const expirationDate = "{{ $timer }}";

            function updateCountdown() {
                const now = new Date().getTime(); // زمان فعلی
                const timeRemaining = expirationDate - now; // محاسبه زمان باقی‌مانده

                if (timeRemaining > 0) {
                    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    $('.timer').text(`${days}:${hours}:${minutes}:${seconds} زمان باقی مانده`);
                } else {
                    $('.timer').text('زمان به پایان رسیده است!');
                    clearInterval(timer); // متوقف کردن تایمر
                }
            }

            // اجرای تابع به صورت هر ثانیه
            const timer = setInterval(updateCountdown, 1000);

            // اولین بار فراخوانی تابع
            updateCountdown();
        });
    </script>
@endpush
