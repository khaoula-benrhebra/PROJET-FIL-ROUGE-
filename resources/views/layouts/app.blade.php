<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <title>Food Funday Restaurant - @yield('title')</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link id="changeable-colors" rel="stylesheet" href="{{ asset('css/colors/orange.css') }}" />
    <script src="{{ asset('js/modernizer.js') }}"></script>
</head>
<body>
    <div id="loader">
        <div id="status"></div>
    </div>
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
    @include('partials.scripts')
</body>
</html>