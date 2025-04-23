
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <title>Food Funday - @yield('title')</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" /> --}}
    {{-- <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link id="changeable-colors" rel="stylesheet" href="{{ asset('css/colors/orange.css') }}" />
    <script src="{{ asset('js/modernizer.js') }}"></script>
</head>
<body class="profile-page">
    <div id="loader">
        <div id="status"></div>
    </div>
    <div class="profile-container">
        <div class="back-to-home">
            <a href="{{ route('home') }}" class="btn btn-back"><i class="fa fa-arrow-left"></i> Retour à l'accueil</a>
        </div>
        @yield('content')
    </div>
    @include('partials.scripts')
</body>
</html>