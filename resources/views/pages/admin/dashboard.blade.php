<!-- dashboard.blade.php -->
@extends('layouts.admin') 

@section('title', 'Dashboard')

@section('content')
    <!-- Dashboard Tab -->
    <div id="dashboard" class="tab-content active">
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-info">
                    <h3>8</h3>
                    <p>Catégories</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>120</h3>
                    <p>Utilisateurs</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>67</h3>
                    <p>Commandes</p>
                </div>
            </div>
        </div>

        <!-- Gestion des Catégories -->
        <div class="content-section">
            <div class="section-header">
                <h2>Gestion Rapide des Catégories</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Nouvelle Catégorie</button>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Nb de Repas</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Entrées</td>
                            <td>Toutes les entrées et amuse-bouches</td>
                            <td>12</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Plats Principaux</td>
                            <td>Plats principaux pour tous les goûts</td>
                            <td>18</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Desserts</td>
                            <td>Desserts variés et gourmands</td>
                            <td>10</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Gestion des Gérants -->
        <div class="content-section">
            <div class="section-header">
                <h2>Gestion des Gérants</h2>
            </div>
            <div class="user-cards">
                @forelse ($allManagers as $manager)
                    <div class="user-card">
                        <div class="user-card-header" style="{{ $manager->is_approved ? 'background-color: var(--success);' : '' }}">
                            <h3>{{ $manager->is_approved ? 'Gérant Approuvé' : 'Nouvel Utilisateur' }}</h3>
                        </div>
                        <div class="user-card-body">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info">
                                <h3>{{ $manager->name }}</h3>
                                <p>{{ $manager->email }}</p>
                                <p>Inscrit le: {{ $manager->created_at->format('d/m/Y') }}</p>
                                @if($manager->is_approved)
                                    <p class="text-success"><i class="fas fa-check-circle"></i> Approuvé</p>
                                @else
                                    <p class="text-warning"><i class="fas fa-clock"></i> En attente</p>
                                @endif
                            </div>
                            <div class="user-action-buttons">
                                @if(!$manager->is_approved)
                                    <form action="{{ route('admin.users.approve', $manager->id) }}" method="POST" class="approve-form">
                                        @csrf
                                        <button type="submit" class="user-action-btn btn-approve">Approuver</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.delete', $manager->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="user-action-btn btn-decline">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Aucun gérant trouvé.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Autres onglets -->
    <div id="categories" class="tab-content">
        <h2>Catégories</h2>
        <!-- Contenu spécifique aux catégories -->
    </div>

    <div id="users" class="tab-content">
        <h2>Utilisateurs</h2>
        <!-- Contenu spécifique aux utilisateurs -->
    </div>

    <div id="statistics" class="tab-content">
        <h2>Statistiques</h2>
        <!-- Contenu spécifique aux statistiques -->
    </div>
@endsection