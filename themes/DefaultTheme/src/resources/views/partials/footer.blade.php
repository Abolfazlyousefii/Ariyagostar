<!-- Start footer -->
<footer class="main-footer dt-sl position-relative">
    <div class="back-to-top">
        <a href="#"><span class="icon"><i class="mdi mdi-chevron-up"></i></span> <span>{{ trans('front::messages.index.back-to-top') }}</span></a>
    </div>
    <div class="container main-container">
        <div class="footer-widgets">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <div class="widget-menu widget card h-100">
                        <header class="card-header">
                            <h3 class="card-title">دسترسی سریع</h3>
                        </header>
                        <ul class="footer-menu">
                            @forelse($footer_links as $group)
                                @foreach($links->where('link_group_id', $group['key']) as $link)
                                    <li>
                                        <a href="{{ $link->link }}">{{ $link->title }}</a>
                                    </li>
                                @endforeach
                            @empty
                                <li><a href="{{ route('front.index') }}">صفحه اصلی</a></li>
                                <li><a href="{{ route('front.contact.index') }}">تماس با ما</a></li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <div class="widget-menu widget card h-100">
                        <header class="card-header">
                            <h3 class="card-title">معرفی آریا</h3>
                        </header>
                        <div class="card-body pt-2">
                            <p class="mb-0 text-muted">
                                {{ option('info_short_description', 'شرکت آریا با هدف ارائه محصولات باکیفیت و خدمات حرفه‌ای، همراه مطمئن شما در خرید آنلاین است.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <div class="widget-menu widget card h-100">
                        <header class="card-header">
                            <h3 class="card-title">اطلاعات تماس و شبکه‌های اجتماعی</h3>
                        </header>
                        <ul class="footer-menu mb-2">
                            @if(option('info_tel'))
                                <li><i class="mdi mdi-phone mr-1"></i>{{ option('info_tel') }}</li>
                            @endif
                            @if(option('info_email'))
                                <li><i class="mdi mdi-email-outline mr-1"></i>{{ option('info_email') }}</li>
                            @endif
                            @if(option('info_address'))
                                <li><i class="mdi mdi-map-marker mr-1"></i>{{ option('info_address') }}</li>
                            @endif
                        </ul>
                        <div class="socials px-3 pb-3">
                            <div class="footer-social">
                                <ul class="text-center">
                                    @if(option('social_instagram'))
                                        <li><a href="{{ option('social_instagram') }}" aria-label="instagram"><i class="mdi mdi-instagram"></i></a></li>
                                    @endif
                                    @if(option('social_whatsapp'))
                                        <li><a href="{{ option('social_whatsapp') }}" aria-label="whatsapp"><i class="mdi mdi-whatsapp"></i></a></li>
                                    @endif
                                    @if(option('social_telegram'))
                                        <li><a href="{{ option('social_telegram') }}" aria-label="telegram"><i class="mdi mdi-telegram"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <div class="widget-menu widget card h-100">
                        <header class="card-header">
                            <h3 class="card-title">نماد اعتماد</h3>
                        </header>
                        <div class="symbol footer-logo py-3 text-center">
                            @if(option('info_enamad'))
                                {!! option('info_enamad') !!}
                            @endif

                            @if(option('info_samandehi'))
                                {!! option('info_samandehi') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="copyright">
        <div class="container main-container">
            <p class="text-center">{{ option('info_footer_text') }}</p>
        </div>
    </div>
</footer>
<!-- End footer -->
