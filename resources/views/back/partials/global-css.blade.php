<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('back/app-assets/css-rtl/custom-rtl.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/style-rtl.css') }}?v=11">
<!-- END: Custom CSS-->

<!-- font css file -->
@if (user_option('theme_font', 'Vazir') == 'Vazir')
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/fonts/vazir/style.css') }}">
@else
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/fonts/iransansdn/style.css') }}">
@endif
