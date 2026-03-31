<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>
        @isset($title)
            {{  $title }}
        @else
            چاپ
        @endisset
    </title>

    <link rel="stylesheet" type="text/css" href="{{ asset('back/app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/print.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('back/assets/fonts/vazir/style.css') }}">

    @stack('styles')

</head>


<body>
    @yield('content')

    @stack('scripts')
</body>

</html>
