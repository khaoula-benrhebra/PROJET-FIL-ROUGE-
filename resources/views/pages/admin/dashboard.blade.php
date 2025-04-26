@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div id="dashboard" class="tab-content active">
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $statistics['users_count'] }}</h3>
                    <p>Utilisateurs</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $statistics['categories_count'] }}</h3>
                    <p>Catégories</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $statistics['restaurants_count'] }}</h3>
                    <p>Restaurants</p>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Gestion des Restaurants</h2>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du Restaurant</th>
                            <th>Gérant</th>
                            <th>Adresse</th>
                            <th>Catégories</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($restaurants as $restaurant)
                            <tr>
                                <td>{{ $restaurant->id }}</td>
                                <td>{{ $restaurant->name }}</td>
                                <td>{{ $restaurant->user->name }}</td>
                                <td>{{ $restaurant->address }}</td>
                                <td>
                                    @foreach($restaurant->categories as $category)
                                        {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="action-btn delete restaurant-delete-btn"
                                            data-id="{{ $restaurant->id }}" data-name="{{ $restaurant->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-table">Aucun restaurant trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <div id="deleteRestaurantModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Confirmer la suppression</h3>
                <p>Êtes-vous sûr de vouloir supprimer le restaurant <span id="restaurantNameToDelete"></span> ?</p>
                <div class="modal-actions">
                    <button id="cancelRestaurantDelete" class="btn btn-secondary">Annuler</button>
                    <form id="deleteRestaurantForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Gestion des Catégories</h2>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Catégorie
                </a>
            </div>

            <div class="table-container">
                @if(isset($categories))
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="action-btn delete category-delete-btn"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-table">Aucune catégorie trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-list"></i>
                        <p>Aucune catégorie trouvée. Commencez par en créer une !</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus"></i> Créer une catégorie
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div id="deleteCategoryModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Confirmer la suppression</h3>
                <p>Êtes-vous sûr de vouloir supprimer la catégorie <span id="categoryNameToDelete"></span> ?</p>
                <div class="modal-actions">
                    <button id="cancelCategoryDelete" class="btn btn-secondary">Annuler</button>
                    <form id="deleteCategoryForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="content-section">
            <div class="section-header">
                <h2>Gestion des Gérants</h2>
            </div>
            <div class="user-cards">
                @forelse ($allManagers as $manager)
                    <div class="user-card">
                        <div class="user-card-header"
                            style="{{ $manager->is_approved ? 'background-color: var(--success);' : '' }}">
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
                                    <form action="{{ route('admin.users.approve', $manager->id) }}" method="POST"
                                        class="approve-form">
                                        @csrf
                                        <button type="submit" class="user-action-btn btn-approve">Approuver</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.delete', $manager->id) }}" method="POST"
                                    class="delete-form">
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


    <div id="categories" class="tab-content">
        <h2>Catégories</h2>
    </div>

    <div id="users" class="tab-content">
        <h2>Utilisateurs</h2>

    </div>

    <div id="statistics" class="tab-content">
        <h2>Statistiques</h2>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            document.querySelectorAll('.category-delete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const categoryId = this.dataset.id;
                    const categoryName = this.dataset.name;

                    document.getElementById('categoryNameToDelete').textContent = categoryName;
                    document.getElementById('deleteCategoryForm').action = `{{ url('admin/categories') }}/${categoryId}`;


                    const modal = document.getElementById('deleteCategoryModal');
                    modal.style.display = "block";

                    document.querySelector('#deleteCategoryModal .close').onclick = function () {
                        modal.style.display = "none";
                    }

                    document.getElementById('cancelCategoryDelete').onclick = function () {
                        modal.style.display = "none";
                    }

                    window.onclick = function (event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                });
            });


            document.querySelectorAll('.restaurant-delete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const restaurantId = this.dataset.id;
                    const restaurantName = this.dataset.name;

                    document.getElementById('restaurantNameToDelete').textContent = restaurantName;
                    document.getElementById('deleteRestaurantForm').action = `{{ url('admin/restaurants') }}/${restaurantId}`;

                    const modal = document.getElementById('deleteRestaurantModal');
                    modal.style.display = "block";

                    document.querySelector('#deleteRestaurantModal .close').onclick = function () {
                        modal.style.display = "none";
                    }

                    document.getElementById('cancelRestaurantDelete').onclick = function () {
                        modal.style.display = "none";
                    }

                    window.onclick = function (event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                });
            });
        });
    </script>
@endsection