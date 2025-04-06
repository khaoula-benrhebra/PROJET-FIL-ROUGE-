@extends('layouts.gerant')

@section('title', 'Tableau de bord - Gérant')

@section('content')
<div class="dashboard-container">
    <!-- Main content area -->
    <div class="dashboard-content">
        <!-- Statistiques -->
        <div class="dashboard-section">
            <h2 class="section-title">Statistiques</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>124</h3>
                        <p>Réservations du jour</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>356</h3>
                        <p>Clients attendus</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-cutlery" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>28</h3>
                        <p>Tables occupées</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-eur" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>4,250 €</h3>
                        <p>Revenu journalier</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations récentes -->
        <div class="dashboard-section">
            <h2 class="section-title">Réservations récentes</h2>
            <div class="table-responsive">
                <table class="reservations-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Personnes</th>
                            <th>Occasion</th>
                            <th>Préférences</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jean Dupont</td>
                            <td>06/04/2025</td>
                            <td>19:30</td>
                            <td>4</td>
                            <td>Anniversaire</td>
                            <td>Continental</td>
                            <td>
                                <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                                <button class="action-btn confirm-btn"><i class="fa fa-check"></i></button>
                                <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Marie Leclerc</td>
                            <td>06/04/2025</td>
                            <td>20:00</td>
                            <td>2</td>
                            <td>Dîner</td>
                            <td>Indien</td>
                            <td>
                                <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                                <button class="action-btn confirm-btn"><i class="fa fa-check"></i></button>
                                <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Pierre Martin</td>
                            <td>06/04/2025</td>
                            <td>21:15</td>
                            <td>6</td>
                            <td>Anniversaire</td>
                            <td>Mexicain</td>
                            <td>
                                <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                                <button class="action-btn confirm-btn"><i class="fa fa-check"></i></button>
                                <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sophie Petit</td>
                            <td>07/04/2025</td>
                            <td>12:30</td>
                            <td>3</td>
                            <td>Déjeuner d'affaires</td>
                            <td>Continental</td>
                            <td>
                                <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                                <button class="action-btn confirm-btn"><i class="fa fa-check"></i></button>
                                <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Lucas Bernard</td>
                            <td>07/04/2025</td>
                            <td>19:45</td>
                            <td>8</td>
                            <td>Anniversaire</td>
                            <td>Indien</td>
                            <td>
                                <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                                <button class="action-btn confirm-btn"><i class="fa fa-check"></i></button>
                                <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection