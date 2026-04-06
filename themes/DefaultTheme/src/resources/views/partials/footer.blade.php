<!-- Start footer -->
@php
    $quickLinks = collect($links)->filter(function ($link) {
        return filled($link->title ?? null) && filled($link->link ?? null);
    })->take(4);

    $aboutText = trim(strip_tags((string) option('info_short_description')));
@endphp

<footer class="main-footer main-footer--modern dt-sl position-relative">
    <div class="footer-back-to-top">
        <a href="#" aria-label="بازگشت به بالا">
            <i class="mdi mdi-chevron-up"></i>
            <span>{{ trans('front::messages.index.back-to-top') }}</span>
        </a>
    </div>

    <div class="container main-container">
        <div class="footer-modern__content">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <section class="footer-modern__section">
                        <h3 class="footer-modern__title">دسترسی سریع</h3>
                        @if($quickLinks->isNotEmpty())
                            <ul class="footer-modern__links list-unstyled mb-0">
                                @foreach($quickLinks as $link)
                                    <li>
                                        <a href="{{ $link->link }}">
                                            <i class="mdi mdi-chevron-left"></i>
                                            <span>{{ $link->title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <section class="footer-modern__section">
                        <h3 class="footer-modern__title">معرفی کوتاه شرکت</h3>
                        @if(filled($aboutText))
                            <p class="footer-modern__about mb-0">
                                {{ \Illuminate\Support\Str::limit($aboutText, 260) }}
                            </p>
                        @endif
                    </section>
                </div>

                <div class="col-12 col-lg-4">
                    <section class="footer-modern__section">
                        <h3 class="footer-modern__title">آدرس و اطلاعات تماس</h3>

                        <ul class="footer-modern__contact list-unstyled mb-0">
                            @if(option('info_address'))
                                <li>
                                    <i class="mdi mdi-map-marker-outline"></i>
                                    <span>{{ option('info_address') }}</span>
                                </li>
                            @endif

                            @if(option('info_tel'))
                                <li>
                                    <i class="mdi mdi-phone-outline"></i>
                                    <a href="tel:{{ option('info_tel') }}">{{ option('info_tel') }}</a>
                                </li>
                            @endif
                        </ul>

                        <div class="footer-modern__socials" aria-label="شبکه‌های اجتماعی">
                            @if(option('social_instagram'))
                                <a href="{{ option('social_instagram') }}" target="_blank" rel="noopener" aria-label="اینستاگرام" title="اینستاگرام">
                                    <i class="mdi mdi-instagram"></i>
                                </a>
                            @endif

                            @if(option('social_telegram'))
                                <a href="{{ option('social_telegram') }}" target="_blank" rel="noopener" aria-label="تلگرام" title="تلگرام">
                                    <i class="mdi mdi-telegram"></i>
                                </a>
                            @endif

                            @if(option('social_whatsapp'))
                                <a href="{{ option('social_whatsapp') }}" target="_blank" rel="noopener" aria-label="واتساپ" title="واتساپ">
                                    <i class="mdi mdi-whatsapp"></i>
                                </a>
                            @endif
                        </div>

                        @if(option('info_enamad') || option('info_samandehi'))
                            <div class="footer-modern__trusts" aria-label="نماد اعتماد">
                                @if(option('info_enamad'))
                                    <div class="footer-modern__trust-item">{!! option('info_enamad') !!}</div>
                                @endif

                                @if(option('info_samandehi'))
                                    <div class="footer-modern__trust-item">{!! option('info_samandehi') !!}</div>
                                @endif
                            </div>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container main-container">
            <p class="text-center mb-0">{{ option('info_footer_text') }}</p>
        </div>
    </div>
</footer>
<!-- End footer -->
