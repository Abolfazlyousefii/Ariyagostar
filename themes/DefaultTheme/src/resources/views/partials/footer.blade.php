<!-- Start footer -->
@php
    $quickLinks = collect($links)->filter(function ($link) {
        return filled($link->title ?? null) && filled($link->link ?? null);
    })->take(4);

    if ($quickLinks->isEmpty()) {
        $quickLinks = collect([
            (object) ['title' => 'صفحه اصلی', 'link' => route('front.index')],
            (object) ['title' => 'فروشگاه', 'link' => route('front.products.index')],
            (object) ['title' => 'وبلاگ', 'link' => route('front.blog.index')],
            (object) ['title' => 'تماس با ما', 'link' => route('front.contact.index')],
        ]);
    }

    $aboutText = trim(strip_tags((string) option('info_short_description')));

    if (!filled($aboutText)) {
        $aboutText = 'ما با تمرکز بر کیفیت کالا، ارسال سریع و پشتیبانی پاسخ‌گو، تلاش می‌کنیم تجربه‌ای مطمئن و حرفه‌ای از خرید آنلاین برای مشتریان فراهم کنیم.';
    }
@endphp

<footer class="main-footer footer-pro dt-sl position-relative">
    <div class="footer-pro__back-to-top">
        <a href="#" aria-label="بازگشت به بالا">
            <i class="mdi mdi-chevron-up"></i>
            <span>{{ trans('front::messages.index.back-to-top') }}</span>
        </a>
    </div>
    <div class="container main-container">
        <div class="footer-pro__wrapper">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                    <section class="footer-pro__section">
                        <h3 class="footer-pro__title">دسترسی سریع</h3>
                        <ul class="footer-pro__links list-unstyled mb-0">
                            @foreach($quickLinks as $link)
                                <li>
                                    <a href="{{ $link->link }}">
                                        <i class="mdi mdi-chevron-left"></i>
                                        <span>{{ $link->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                    <section class="footer-pro__section">
                        <h3 class="footer-pro__title">معرفی شرکت</h3>
                        <p class="footer-pro__about mb-0">{{ \Illuminate\Support\Str::limit($aboutText, 240) }}</p>
                    </section>
                </div>

                <div class="col-12 col-lg-4">
                    <section class="footer-pro__section">
                        <h3 class="footer-pro__title">تماس با ما</h3>

                        <ul class="footer-pro__contact list-unstyled mb-0">
                            @if(option('info_address'))
                                <li>
                                    <i class="mdi mdi-map-marker-outline"></i>
                                    <span>{{ option('info_address') }}</span>
                                </li>
                            @endif

                        @if(option('info_enamad'))
                            {!! option('info_enamad') !!}
                        @endif

                        @if(option('info_samandehi'))
                            {!! option('info_samandehi') !!}
                        @endif

                        <div class="footer-pro__socials" aria-label="شبکه‌های اجتماعی">
                            @if(option('social_instagram'))
                                <a href="{{ option('social_instagram') }}" target="_blank" rel="noopener" aria-label="اینستاگرام">
                                    <i class="mdi mdi-instagram"></i>
                                </a>
                            @endif

                                @if(option('social_whatsapp'))
                                    <li><a href="{{ option('social_whatsapp') }}"><i class="mdi mdi-whatsapp"></i></a></li>
                                @endif

                                @if(option('social_telegram'))
                                    <li><a href="{{ option('social_telegram') }}"><i class="mdi mdi-telegram"></i></a></li>
                                @endif

                        @if(option('info_enamad') || option('info_samandehi'))
                            <div class="footer-pro__trusts" aria-label="نماد اعتماد الکترونیکی">
                                @if(option('info_enamad'))
                                    <div class="footer-pro__trust-item">{!! option('info_enamad') !!}</div>
                                @endif
                                @if(option('info_samandehi'))
                                    <div class="footer-pro__trust-item">{!! option('info_samandehi') !!}</div>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="copyright footer-pro__copyright">
        <div class="container main-container">
            <p class="text-center">{{ option('info_footer_text') }}</p>
        </div>
    </div>
</footer>
<!-- End footer -->
