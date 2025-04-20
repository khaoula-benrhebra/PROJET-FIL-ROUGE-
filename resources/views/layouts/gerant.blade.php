<!DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profileGerant.css') }}">
    <link rel="stylesheet" href="{{ asset('css/restaurant.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu-gerant.css') }}">
  
</head>
<body class="dashboard-body">
    <div class="dashboard-wrapper">
        <div class="sidebar-toggle" id="sidebarToggle">
            <span class="toggle-icon"><i class="fa fa-bars"></i></span>
        </div>
        <div class="sidebar" id="sidebar">
            
            <div class="sidebar-user">
                <div class="user-image">
                    @if(Auth::user()->getFirstMediaUrl('profile'))
                        <img src="{{ Auth::user()->getFirstMediaUrl('profile') }}" alt="{{ Auth::user()->name }}">
                    @else
                        <img src="{{ asset('images/staff-01.jpg') }}" alt="Gérant">
                    @endif
                </div>
                <div class="user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->role->name }}</p>
                </div>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('gerant.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Tableau de bord</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-calendar"></i> <span>Réservations</span></a>
                </li>
                <li>
                    <a href="{{ route('gerant.menu') }}"><i class="fa fa-cutlery"></i> <span>Menu</span></a>
                </li>
               
                <li>
                    <a href="{{ route('gerant.restaurant.index') }}"><i class="fa fa-coffee"></i> <span>Mon Restaurant</span></a>
                </li>
                <li>
                    <a href="{{ route('gerant.tables.index') }}"><i class="fa fa-calendar"></i> <span>Tables</span></a>
                </li>
                <li>
                    <a href="{{ route('gerant.profile') }}"><i class="fa fa-cog"></i> <span>Paramètres</span></a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> <span>Déconnexion</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('active');
                $('.main-content').toggleClass('full-width');
            });
            $('#sidebarClose').click(function() {
                $('#sidebar').removeClass('active');
                $('.main-content').removeClass('full-width');
            });
            $(document).click(function(e) {
                const sidebar = $('#sidebar');
                const sidebarToggle = $('#sidebarToggle');
                
                if (!sidebar.is(e.target) && 
                    sidebar.has(e.target).length === 0 &&
                    !sidebarToggle.is(e.target) && 
                    sidebarToggle.has(e.target).length === 0 &&
                    sidebar.hasClass('active')) {
                    
                    sidebar.removeClass('active');
                    $('.main-content').removeClass('full-width');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>