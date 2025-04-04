@extends('layouts.app-manager')

@section('title', 'Dashboard Gérant')

@section('content')
<div class="dashboard-container">
    <!-- Side Bar -->
    <div class="sidebar">
        <div class="sidebar-profile">
            <div class="profile-image">
                <img src="{{ asset('images/profile-placeholder.jpg') }}" alt="Profile" id="profile-img">
                <div class="upload-overlay">
                    <label for="profile-upload">
                        <i class="fa fa-camera"></i>
                    </label>
                    <input type="file" id="profile-upload" class="hidden">
                </div>
            </div>
            <h3 id="restaurant-name">Food Funday</h3>
            <p class="owner-name">John Doggett</p>
        </div>
        
        <ul class="sidebar-menu">
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i> <span>Tableau de bord</span></a></li>
            <li><a href="#"><i class="fa fa-calendar"></i> <span>Réservations</span></a></li>
            <li><a href="#"><i class="fa fa-cutlery"></i> <span>Menu</span></a></li>
            <li><a href="#"><i class="fa fa-users"></i> <span>Personnel</span></a></li>
            <li><a href="#"><i class="fa fa-cog"></i> <span>Paramètres</span></a></li>
            <li><a href="#"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <div class="dashboard-header">
            <button class="menu-toggle" id="menu-toggle">
                <i class="fa fa-bars"></i>
            </button>
            <h2>Tableau de bord</h2>
            <div class="date-display">
                <i class="fa fa-calendar"></i> <span id="current-date"></span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-calendar-check-o"></i>
                        </div>
                        <div class="stat-details">
                            <h3>24</h3>
                            <p>Réservations aujourd'hui</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3>142</h3>
                            <p>Clients cette semaine</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="stat-details">
                            <h3>3,580€</h3>
                            <p>Revenus cette semaine</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="stat-details">
                            <h3>4.8</h3>
                            <p>Note moyenne</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="dashboard-panel">
                    <div class="panel-header">
                        <h4>Revenus mensuels</h4>
                        <div class="panel-actions">
                            <select class="select-period">
                                <option>Cette année</option>
                                <option>Année précédente</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <canvas id="revenue-chart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="dashboard-panel">
                    <div class="panel-header">
                        <h4>Plats populaires</h4>
                    </div>
                    <div class="panel-body">
                        <canvas id="popular-dishes" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservations and Reviews Row -->
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="dashboard-panel">
                    <div class="panel-header">
                        <h4>Réservations récentes</h4>
                        <div class="panel-actions">
                            <a href="#" class="view-all">Voir tout</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="reservation-list">
                            <div class="reservation-item">
                                <div class="reservation-details">
                                    <h5>Martin Dupont</h5>
                                    <p><i class="fa fa-calendar"></i> Aujourd'hui, 19:30</p>
                                    <p><i class="fa fa-users"></i> 4 personnes</p>
                                </div>
                                <div class="reservation-status confirmed">
                                    Confirmé
                                </div>
                            </div>
                            <div class="reservation-item">
                                <div class="reservation-details">
                                    <h5>Sophie Martin</h5>
                                    <p><i class="fa fa-calendar"></i> Aujourd'hui, 20:00</p>
                                    <p><i class="fa fa-users"></i> 2 personnes</p>
                                </div>
                                <div class="reservation-status confirmed">
                                    Confirmé
                                </div>
                            </div>
                            <div class="reservation-item">
                                <div class="reservation-details">
                                    <h5>Philippe Dubois</h5>
                                    <p><i class="fa fa-calendar"></i> Demain, 12:30</p>
                                    <p><i class="fa fa-users"></i> 6 personnes</p>
                                </div>
                                <div class="reservation-status pending">
                                    En attente
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="dashboard-panel">
                    <div class="panel-header">
                        <h4>Avis récents</h4>
                        <div class="panel-actions">
                            <a href="#" class="view-all">Voir tout</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="review-list">
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="reviewer">
                                        <img src="{{ asset('images/avatar-placeholder.jpg') }}" alt="Reviewer">
                                        <div>
                                            <h5>Marie Leroux</h5>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="review-date">Hier</span>
                                </div>
                                <p class="review-text">"Un excellent repas, l'ambiance était parfaite et le service impeccable. Je recommande vivement!"</p>
                            </div>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="reviewer">
                                        <img src="{{ asset('images/avatar-placeholder.jpg') }}" alt="Reviewer">
                                        <div>
                                            <h5>Paul Morel</h5>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="review-date">3 jours</span>
                                </div>
                                <p class="review-text">"Très bon restaurant, mais le temps d'attente était un peu long. La nourriture valait l'attente cependant."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection