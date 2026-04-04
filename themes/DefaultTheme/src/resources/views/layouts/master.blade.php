<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">

    <!-- viewport meta -->

    <title>
        @isset($title)
            {{ $title }} |
        @endisset

        {{ option('info_site_title', 'لاراول شاپ') }}
    </title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('meta')

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ option('info_icon', theme_asset('images/favicon-32x32.png')) }}">

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/materialdesignicons.min.css') }}">

    @stack('befor-styles')

    <!-- theme color file -->
    <link rel="stylesheet" href="{{ theme_asset('css/colors/' . option('dt_theme_color', 'default') . '.css') }}?v={{ time() }}">

    @if ($current_local['direction'] == 'ltr')
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/bootstrap.ltr.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/bootstrap.min.css') }}">
    @endif

    @if (config('app.debug'))
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/bootstrap-rtl.min.css') }}">
        <!-- Plugins -->
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/jquery.horizontalmenu.css') }}">
        <link rel="stylesheet" href="{{ theme_asset('js/plugins/toastr/toastr.css') }}">

        <!-- Main CSS File -->
        <link rel="stylesheet" href="{{ theme_asset('css/main.css') }}?v=23">
        <link rel="stylesheet" href="{{ theme_asset('css/styles.css') }}?v=32">
        <link rel="stylesheet" href="{{ theme_asset('css/custom.css') }}?v=2">
        <!-- endinject -->

    @else
        <!-- All Css Files -->
        <link rel="stylesheet" href="{{ mix('css/all.css', config('front.mainfest_path')) }}">
    @endif

    @if ($current_local['direction'] == 'ltr')
        <link rel="stylesheet" href="{{ theme_asset('css/ltr.css') }}?v=2">
    @endif

    @stack('styles')

    {!! option('info_header_codes') !!}
</head>

<body>
    <div class="wrapper @yield('wrapper-classes')">


        <!-- Start header -->
        <header class="main-header dt-sl">

            <!-- Start topbar -->
            <div class="container main-container">
                <div class="wholesale-top-strip">
                  
                </div>
                <div class="topbar dt-sl">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-3 col-4">
                            <div class="logo-area float-right">
                                <a href="{{ route('front.index') }}">
                                    <img data-src="{{ theme_asset('img/AriyaLogo.png') }}" alt="{{ option('info_site_title', 'لاراول شاپ') }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-5 hidden-sm">
                            <div class="search-area dt-sl">
                                <form id="search-form" action="{{ route('front.products.search') }}" class="search">
                                    <input type="text" name="q" value="{{ request('q') }}" id="search-input" autocomplete="off" placeholder="{{ trans('front::messages.header.Search-for-product') }}">
                                    <button type="submit"><img data-src="{{ theme_asset('img/theme/search.png') }}" alt="search button"></button>
                                    <button id="close-search-result" class="close-search-result" type="button"><i class="mdi mdi-close"></i></button>
                                    <div class="search-result p-0" id="search-result">
                                        <ul>

                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 col-8 topbar-left">
                            @include('front::partials.user-menu')
                        </div>
                    </div>
                </div>
            </div>
            <!-- End topbar -->

            <!-- Start bottom-header -->
            <div class="bottom-header dt-sl mb-sm-bottom-header">
                <div class="container main-container">
                    <!-- Start Main-Menu -->
                    @include('front::partials.menu.menu')
                    <!-- End Main-Menu -->
                </div>
            </div>
            <!-- End bottom-header -->
        </header>
        <!-- End header -->


        @yield('content')

        @include('front::partials.footer')
    </div>

    <script>
        var BASE_URL = "{{ route('front.index') }}";
        var IS_RTL = {{ $current_local['direction'] == 'rtl' ? 1 : 0 }};
    </script>

    @if (config('app.debug'))
        <!-- Core JS Files -->
        <script src="{{ theme_asset('js/vendor/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ theme_asset('js/vendor/popper.min.js') }}"></script>
        <script src="{{ theme_asset('js/vendor/bootstrap.min.js') }}"></script>
        <!-- Plugins -->
        <script src="{{ theme_asset('js/vendor/owl.carousel.min.js') }}"></script>
        <script src="{{ theme_asset('js/vendor/jquery.horizontalmenu.js') }}"></script>
        <script src="{{ theme_asset('js/vendor/theia-sticky-sidebar.min.js') }}"></script>
        <script src="{{ theme_asset('js/vendor/jquery.lazyloadxt.min.js') }}"></script>

        <script src="{{ theme_asset("js/plugins/jquery.blockUI.js") }}"></script>
        <script src="{{ theme_asset("js/plugins/sweetalert2.all.min.js") }}"></script>
        <script src="{{ theme_asset("js/plugins/toastr/toastr.min.js") }}"></script>

        <!-- Main JS File -->
        <script src="{{ theme_asset('js/main.js') }}?v=5"></script>
        <script src="{{ theme_asset('js/custom.js') }}"></script>
        <script src="{{ theme_asset("js/scripts.js") }}?v=15"></script>
    @else
        <!-- All JS Files -->
        <script src="{{ mix('js/all.js', config('front.mainfest_path')) }}"></script>
    @endif

    @stack('scripts')

    @if ($current_local['direction'] == 'ltr')
        <script src="{{ theme_asset('js/ltr.js') }}"></script>
    @endif

{{--    @toastr_render--}}

    {!! option('info_scripts') !!}
    <!-- endinject -->
</body>

</html>
