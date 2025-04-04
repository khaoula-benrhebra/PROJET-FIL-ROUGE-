<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Restaurant Admin</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Paprika" rel="stylesheet">
</head>
<body>
    @yield('content')


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion des formulaires d'approbation
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
                            form.closest('.user-card').remove(); // Supprime la carte du DOM
                            alert(data.success);
                        } else {
                            alert('Erreur lors de l\'approbation.');
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });
    
            // Gestion des formulaires de suppression
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
                            form.closest('.user-card').remove(); // Supprime la carte du DOM
                            alert(data.success);
                        } else {
                            alert('Erreur lors de la suppression.');
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });
    
            // Gestion de l'onglet actif
            window.showTab = function(tabId) {
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
                document.getElementById(tabId).classList.add('active');
                document.querySelector(`a[href="#${tabId}"]`).classList.add('active');
            };
        });
    </script>
    
</body>
</html>