<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    
    <!-- Dashboard Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="dashboard-body">
    <div class="dashboard-wrapper">
        <!-- Sidebar Toggle Button (Mobile) -->
        <div class="sidebar-toggle" id="sidebarToggle">
            <span class="toggle-icon"><i class="fa fa-bars"></i></span>
        </div>
        
        <!-- Sidebar -->
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
        
        <!-- Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Bootstrap JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Sidebar toggle for mobile
            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('active');
                $('.main-content').toggleClass('full-width');
            });
            
            // Close sidebar on mobile when X is clicked
            $('#sidebarClose').click(function() {
                $('#sidebar').removeClass('active');
                $('.main-content').removeClass('full-width');
            });
            
            // Close sidebar when clicking outside on mobile
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