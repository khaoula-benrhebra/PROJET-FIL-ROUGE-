<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Restaurant Admin</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Paprika" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles') 
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-user">
            <div class="user-image">
                @if(auth()->user()->getFirstMedia('profile'))
                    <img src="{{ auth()->user()->getFirstMedia('profile')->getUrl() }}" alt="{{ auth()->user()->name }}">
                @else
                    <img src="{{ asset('images/staff-01.jpg') }}" alt="Défaut">
                @endif
            </div>
            <div class="user-info">
                <h4>{{ auth()->user()->name }}</h4>
                <p>Administrateur</p>
            </div>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('home') }}" class="menu-item">
                <i class="fas fa-home"></i> Accueil
            </a>
            <a href="#categories" class="menu-item" onclick="showTab('categories')">
                <i class="fas fa-list"></i> Catégories
            </a>
            <a href="#users" class="menu-item" onclick="showTab('users')">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="#statistics" class="menu-item" onclick="showTab('statistics')">
                <i class="fas fa-chart-bar"></i> Statistiques
            </a>
            <a href="{{ route('admin.profile') }}" class="menu-item">
                <i class="fas fa-cog"></i> Paramètres
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0">
                @csrf
                <button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    
    <div class="main-content">
        <div class="header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        @yield('content') <!-- Section pour le contenu spécifique -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
           
            document.querySelectorAll('.approve-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const url = this.action;
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            form.closest('.user-card').remove();
                            alert(data.success);
                        } else {
                            alert('Erreur lors de l\'approbation.');
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });

          
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if (!confirm('Voulez-vous vraiment supprimer cet utilisateur ?')) return;
                    const url = this.action;
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            form.closest('.user-card').remove();
                            alert(data.success);
                        } else {
                            alert('Erreur lors de la suppression.');
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });

            window.showTab = function(tabId) {
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
                document.getElementById(tabId).classList.add('active');
                document.querySelector(`a[href="#${tabId}"]`).classList.add('active');
            };
        });
    </script>
    @yield('scripts')
</body>
</html>