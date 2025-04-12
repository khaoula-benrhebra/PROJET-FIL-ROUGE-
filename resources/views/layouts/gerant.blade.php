<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    
   
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="dashboard-body">
    <div class="dashboard-wrapper">
        <div class="sidebar-toggle" id="sidebarToggle">
            <span class="toggle-icon"><i class="fa fa-bars"></i></span>
        </div>
        <div class="sidebar" id="sidebar">
            
            <div class="sidebar-user">
                <div class="user-image">
                    <img src="{{ asset('images/staff-01.jpg') }}" alt="Gérant">
                </div>
                <div class="user-info">
                    <h4>John Doggett</h4>
                    <p>Gérant</p>
                </div>
            </div>
            
            <ul class="sidebar-menu">
               
                <li>
                    <a href="#"><i class="fa fa-calendar"></i> <span>Réservations</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-cutlery"></i> <span>Menu</span></a>
                </li>
               
                <li>
                    <a href="#"><i class="fa fa-bar-chart"></i> <span>Statistiques</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-cog"></i> <span>Paramètres</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a>
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
</body>
</html>