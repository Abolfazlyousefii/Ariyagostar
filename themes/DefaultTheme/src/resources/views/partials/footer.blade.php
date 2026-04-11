<!-- Start footer -->
<footer class="main-footer dt-sl position-relative">
    <div class="back-to-top">
        <a href="#" aria-label="{{ trans('front::messages.index.back-to-top') }}">
            <span class="icon"><i class="mdi mdi-chevron-up"></i></span>
            <span>{{ trans('front::messages.index.back-to-top') }}</span>
        </a>
    </div>

    @php
        $enabledSections = collect($footerSections ?? [])->where('enabled', true)->sortBy('sort_order')->values();
        $activeLinks = collect($quickLinks ?? [])->where('enabled', true)->sortBy('sort_order')->take(4);

        $companyLogo = option('info_logo') ? asset(option('info_logo')) : theme_asset('img/logo.png');
        $companyTitle = option('info_site_title', 'لاراول شاپ');

        $contactRows = collect([
            [
                'show' => !empty($contactData['show_address']) && !empty($contactData['address']),
                'icon' => 'mdi-map-marker-outline',
                'label' => 'آدرس',
                'value' => $contactData['address'] ?? '',
                'is_link' => false,
            ],
            [
                'show' => !empty($contactData['show_email']) && !empty($contactData['email']),
                'icon' => 'mdi-email-outline',
                'label' => 'ایمیل',
                'value' => $contactData['email'] ?? '',
                'is_link' => true,
                'href' => 'mailto:' . ($contactData['email'] ?? ''),
            ],
            [
                'show' => !empty($contactData['show_phone']) && !empty($contactData['phone']),
                'icon' => 'mdi-phone-outline',
                'label' => 'تلفن',
                'value' => $contactData['phone'] ?? '',
                'is_link' => true,
                'href' => 'tel:' . preg_replace('/\s+/', '', $contactData['phone'] ?? ''),
            ],
            [
                'show' => !empty($contactData['support_phone'] ?? null),
                'icon' => 'mdi-headset',
                'label' => 'پشتیبانی',
                'value' => $contactData['support_phone'] ?? '',
                'is_link' => true,
                'href' => 'tel:' . preg_replace('/\s+/', '', $contactData['support_phone'] ?? ''),
            ],
            [
                'show' => !empty($contactData['warranty_phone'] ?? null),
                'icon' => 'mdi-shield-check-outline',
                'label' => 'گارانتی',
                'value' => $contactData['warranty_phone'] ?? '',
                'is_link' => true,
                'href' => 'tel:' . preg_replace('/\s+/', '', $contactData['warranty_phone'] ?? ''),
            ],
        ])->where('show', true)->values();
    @endphp

    <div class="container main-container">
        <div class="footer-widgets footer-grid-wrap">
            <div class="row">
                @foreach($enabledSections as $section)
                    @if($section['type'] === 'quick_links')
                        <div class="col-12 col-md-6 col-lg-3 mb-3 footer-col footer-col-quick-links">
                            <div class="widget-menu widget card h-100">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>
                                <ul class="footer-menu footer-quick-links mb-0">
                                    @forelse($activeLinks as $link)
                                        <li>
                                            <a href="{{ $link['url'] }}">
                                                <i class="mdi mdi-chevron-left"></i>
                                                <span>{{ $link['label'] }}</span>
                                            </a>
                                        </li>
                                    @empty
                                        <li><a href="{{ route('front.index') }}"><i class="mdi mdi-chevron-left"></i><span>صفحه اصلی</span></a></li>
                                        <li><a href="{{ route('front.contact.index') }}"><i class="mdi mdi-chevron-left"></i><span>تماس با ما</span></a></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if($section['type'] === 'company_intro')
                        <div class="col-12 col-md-6 col-lg-4 mb-3 footer-col footer-col-company">
                            <div class="widget-menu widget card h-100 footer-company-card">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>
                                <div class="card-body pt-1">
                                    <div class="footer-company-head">
                                        <img src="{{ $companyLogo }}" alt="{{ $companyTitle }}" class="footer-company-logo">
                                        <div>
                                            <h4 class="footer-company-name mb-1">{{ $companyTitle }}</h4>
                                            <p class="footer-company-tagline mb-0">همراه مطمئن شما در خرید آنلاین</p>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-muted footer-company-description">{{ $companyDescription }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($section['type'] === 'contact_social')
                        <div class="col-12 col-md-6 col-lg-3 mb-3 footer-col footer-col-contact">
                            <div class="widget-menu widget card h-100">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>

                                <ul class="footer-menu footer-contact-list mb-3">
                                    @foreach($contactRows as $row)
                                        <li>
                                            <i class="mdi {{ $row['icon'] }}"></i>
                                            <strong>{{ $row['label'] }}:</strong>
                                            @if(!empty($row['is_link']))
                                                <a href="{{ $row['href'] }}">{{ $row['value'] }}</a>
                                            @else
                                                <span>{{ $row['value'] }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="socials px-0 pb-0 mt-auto">
                                    <div class="footer-social">
                                        <ul class="text-right mb-0">
                                            @if(!empty($contactData['show_instagram']) && !empty($contactData['instagram']))
                                                <li><a href="{{ $contactData['instagram'] }}" aria-label="instagram" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-instagram"></i></a></li>
                                            @endif
                                            @if(!empty($contactData['show_whatsapp']) && !empty($contactData['whatsapp']))
                                                <li><a href="{{ $contactData['whatsapp'] }}" aria-label="whatsapp" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-whatsapp"></i></a></li>
                                            @endif
                                            @if(!empty($contactData['show_telegram']) && !empty($contactData['telegram']))
                                                <li><a href="{{ $contactData['telegram'] }}" aria-label="telegram" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-telegram"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($section['type'] === 'trust_badge')
                        <div class="col-12 col-md-6 col-lg-2 mb-3 footer-col footer-col-trust-badge">
                            <div class="widget-menu widget card h-100">
                                <header class="card-header">
                                    <h3 class="card-title">{{ $section['title'] }}</h3>
                                </header>
                                <div class="symbol footer-logo py-2 text-center">
                                    @if(!empty($contactData['show_trust_badge']) && !empty($contactData['trust_badge_image']))
                                        @if(!empty($contactData['trust_badge_url']))
                                            <a href="{{ $contactData['trust_badge_url'] }}" target="_blank" rel="nofollow noopener noreferrer">
                                                <img src="{{ asset($contactData['trust_badge_image']) }}" alt="enamad" class="footer-trust-image">
                                            </a>
                                        @else
                                            <img src="{{ asset($contactData['trust_badge_image']) }}" alt="enamad" class="footer-trust-image">
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
            <p class="text-center mb-1">{{ option('info_footer_text') }}</p>
            @if(option('info_footer_designer'))
                <p class="text-center mb-0 footer-designer">{{ option('info_footer_designer') }}</p>
            @endif
        </div>
    </div>
</footer>
<!-- End footer -->
