document.addEventListener('DOMContentLoaded', function() {
    // Afficher la date actuelle
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const currentDate = new Date().toLocaleDateString('fr-FR', options);
    document.getElementById('current-date').textContent = currentDate;
    
    // Toggle menu pour mobile
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const body = document.body;
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            body.classList.toggle('sidebar-active');
        });
    }
    
    // Fermer le menu sur clic en dehors
    document.addEventListener('click', function(event) {
        if (body.classList.contains('sidebar-active') && 
            !sidebar.contains(event.target) && 
            event.target !== menuToggle) {
            sidebar.classList.remove('active');
            body.classList.remove('sidebar-active');
        }
    });
    
    // Graphique des revenus
    if (document.getElementById('revenue-chart')) {
        const revenueCtx = document.getElementById('revenue-chart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Revenus mensuels (€)',
                    data: [12000, 19000, 15000, 17000, 16000, 23000, 25000, 22000, 18000, 16000, 19000, 22000],
                    backgroundColor: 'rgba(231, 91, 30, 0.1)',
                    borderColor: '#e75b1e',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Graphique des plats populaires
    if (document.getElementById('popular-dishes')) {
        const dishesCtx = document.getElementById('popular-dishes').getContext('2d');
        const dishesChart = new Chart(dishesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Risotto', 'Steak', 'Saumon', 'Pâtes', 'Salade'],
                datasets: [{
                    data: [30, 25, 20, 15, 10],
                    backgroundColor: [
                        '#e75b1e',
                        '#f04900',
                        '#ff7e47',
                        '#ff9a6b',
                        '#ffb78e'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    // Prévisualisation de l'image de profil
    const profileUpload = document.getElementById('profile-upload');
    if (profileUpload) {
        profileUpload.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-img').src = e.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
});