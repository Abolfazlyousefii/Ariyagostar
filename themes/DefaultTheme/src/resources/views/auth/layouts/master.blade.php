<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#f7858d">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">
    <meta name="msapplication-navbutton-color" content="#f7858d">
    <meta name="apple-mobile-web-app-status-bar-style" content="#f7858d">
    <title>
        @isset($title)
            {{ $title }} |
        @endisset

        {{ option('info_site_title',  trans('front::messages.auth.laravel-shop') ) }}
    </title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/bootstrap.min.css') }}">
    <!-- Plugins -->
    <link rel="stylesheet" href="{{ theme_asset('js/plugins/toastr/toastr.css') }}">

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/materialdesignicons.min.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ theme_asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/styles.css?v=5') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ option('info_icon', theme_asset('images/favicon-32x32.png')) }}">

    @stack('styles')

    <!-- theme color file -->
    <link rel="stylesheet" href="{{ theme_asset('css/colors/' . option('dt_theme_color', 'default') . '.css') }}?v={{ time() }}">

</head>

<body>

    <div class="wrapper">

        <!-- Start mini-header -->
        <header class="mini-header pt-4 pb-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="logo-area-mini-header">
                            <a href="/">
                                <img src="{{ theme_asset('img/logo.png') }}" alt="{{ option('info_site_title', trans('front::messages.auth.laravel-shop')) }}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- End mini-header -->

        @yield('content')

        <!-- Start mini-footer -->
        <footer class="mini-footer dt-sl">
            <div class="container main-container">
                <div class="row">

                    <div class="col-12 mt-2 mb-3">
                        <div class="footer-light-text">
                            {{ trans('front::messages.auth.all-rights-reserved-to') }}
                             ({{ option('info_site_title', trans('front::messages.auth.laravel-shop')) }})
                            {{ trans('front::messages.auth.is') }}
                        </div>
                    </div>

                </div>
            </div>
        </footer>
        <!-- End mini-footer -->

    </div>

    <!-- Core JS Files -->
    <script src="{{ theme_asset('js/vendor/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/popper.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/bootstrap.min.js') }}"></script>
    <!-- Plugins -->
    <script src="{{ theme_asset('js/vendor/ResizeSensor.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery.blockUI.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/sweetalert2.all.min.js') }}"></script>

    <script src="{{ theme_asset('js/scripts.js?v=6') }}"></script>

    <script src="{{ theme_asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/localization/messages_fa.min.js') }}?v=2"></script>


    <script>
        var BASE_URL = "{{ route('front.index') }}";
    </script>

    @stack('scripts')

    {!! option('info_scripts') !!}
</body>

</html>
