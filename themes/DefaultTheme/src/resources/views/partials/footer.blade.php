<!-- Start footer -->
<footer class="main-footer dt-sl position-relative">
    <div class="back-to-top">
        <a href="#"><span class="icon"><i class="mdi mdi-chevron-up"></i></span> <span>{{ trans('front::messages.index.back-to-top') }}</span></a>
    </div>

    <div class="container main-container">
        <div class="footer-widgets">
            <div class="row">
                @php
                    $enabledSections = collect($footerSections ?? [])->where('enabled', true)->sortBy('sort_order')->values();
                @endphp

                @foreach($enabledSections as $section)
                    @if($section['type'] === 'quick_links')
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="widget-menu widget card h-100">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>
                                <ul class="footer-menu">
                                    @php
                                        $activeLinks = collect($quickLinks ?? [])->where('enabled', true)->sortBy('sort_order')->take(4);
                                    @endphp

                                    @forelse($activeLinks as $link)
                                        <li>
                                            <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                                        </li>
                                    @empty
                                        <li><a href="{{ route('front.index') }}">صفحه اصلی</a></li>
                                        <li><a href="{{ route('front.contact.index') }}">تماس با ما</a></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if($section['type'] === 'company_intro')
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="widget-menu widget card h-100">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>
                                <div class="card-body pt-2">
                                    <p class="mb-0 text-muted">{{ $companyDescription }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($section['type'] === 'contact_social')
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="widget-menu widget card h-100">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>
                                <ul class="footer-menu mb-2">
                                    @if(!empty($contactData['show_phone']) && !empty($contactData['phone']))
                                        <li><i class="mdi mdi-phone mr-1"></i>{{ $contactData['phone'] }}</li>
                                    @endif
                                    @if(!empty($contactData['show_email']) && !empty($contactData['email']))
                                        <li><i class="mdi mdi-email-outline mr-1"></i>{{ $contactData['email'] }}</li>
                                    @endif
                                    @if(!empty($contactData['show_address']) && !empty($contactData['address']))
                                        <li><i class="mdi mdi-map-marker mr-1"></i>{{ $contactData['address'] }}</li>
                                    @endif
                                </ul>
                                <div class="socials px-3 pb-3">
                                    <div class="footer-social">
                                        <ul class="text-center">
                                            @if(!empty($contactData['show_instagram']) && !empty($contactData['instagram']))
                                                <li><a href="{{ $contactData['instagram'] }}" aria-label="instagram"><i class="mdi mdi-instagram"></i></a></li>
                                            @endif
                                            @if(!empty($contactData['show_whatsapp']) && !empty($contactData['whatsapp']))
                                                <li><a href="{{ $contactData['whatsapp'] }}" aria-label="whatsapp"><i class="mdi mdi-whatsapp"></i></a></li>
                                            @endif
                                            @if(!empty($contactData['show_telegram']) && !empty($contactData['telegram']))
                                                <li><a href="{{ $contactData['telegram'] }}" aria-label="telegram"><i class="mdi mdi-telegram"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($section['type'] === 'trust_badge')
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="widget-menu widget card h-100">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>
                                <div class="symbol footer-logo py-3 text-center">
                                    @if(!empty($contactData['show_trust_badge']) && !empty($contactData['trust_badge_image']))
                                        @if(!empty($contactData['trust_badge_url']))
                                            <a href="{{ $contactData['trust_badge_url'] }}" target="_blank" rel="nofollow noopener noreferrer">
                                                <img src="{{ asset($contactData['trust_badge_image']) }}" alt="enamad" style="max-width: 120px;">
                                            </a>
                                        @else
                                            <img src="{{ asset($contactData['trust_badge_image']) }}" alt="enamad" style="max-width: 120px;">
                                        @endif
                                    @else
                                        @if(option('info_enamad'))
                                            {!! option('info_enamad') !!}
                                        @endif

                                        @if(option('info_samandehi'))
                                            {!! option('info_samandehi') !!}
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
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
