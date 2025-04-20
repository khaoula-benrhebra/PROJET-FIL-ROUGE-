@extends('layouts.gerant')

@section('title', 'Gestion du Menu - Gérant')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-section">
        <h2 class="section-title">Gestion du Menu</h2>
        
        <!-- Navigation rapide -->
        <div class="quick-nav">
            <a href="#petit-dejeuner-section" class="quick-nav-link">
                <i class="fa fa-coffee"></i> Petit Déjeuner
            </a>
            <a href="#dejeuner-section" class="quick-nav-link">
                <i class="fa fa-cutlery"></i> Déjeuner
            </a>
            <a href="#diner-section" class="quick-nav-link">
                <i class="fa fa-glass"></i> Dîner
            </a>
        </div>
        
        <!-- Petit Déjeuner Section -->
        <div id="petit-dejeuner-section" class="menu-section" data-menu-id="{{ $menusByType['petit-dejeuner'][0]->id ?? '' }}">
            <div class="menu-section-header">
                <div class="menu-title">
                    <i class="fa fa-coffee section-icon"></i>
                    <h3>Petit Déjeuner</h3>
                </div>
                <a href="{{ route('gerant.meals.create', ['menu_id' => $menusByType['petit-dejeuner'][0]->id ?? '', 'type' => 'petit-dejeuner']) }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Ajouter un item
                </a>
            </div>
            
            <div class="menu-items">
                @if(isset($menusByType['petit-dejeuner']))
                    @foreach($menusByType['petit-dejeuner'][0]->meals as $meal)
                        <div class="menu-item" data-meal-id="{{ $meal->id }}">
                            <div class="item-image">
                                @if($meal->getFirstMediaUrl('meal'))
                                    <img src="{{ $meal->getFirstMediaUrl('meal') }}" alt="{{ $meal->name }}">
                                @else
                                    <img src="{{ asset('images/placeholder-food.jpg') }}" alt="{{ $meal->name }}">
                                @endif
                            </div>
                            <div class="item-details">
                                <h4 class="item-name">{{ $meal->name }}</h4>
                                <p class="item-description">{{ $meal->description }}</p>
                            </div>
                            <div class="item-price">
                                <div class="price-circle">
                                    <span>{{ number_format($meal->price, 2) }} €</span>
                                </div>
                            </div>
                            <div class="item-actions">
                                <a href="{{ route('gerant.meals.edit', $meal->id) }}" class="action-btn edit-btn"><i class="fa fa-pencil"></i></a>
                                <button class="action-btn delete-btn" onclick="confirmDelete({{ $meal->id }})"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="no-items-message">Aucun repas pour le petit déjeuner. Ajoutez-en un !</p>
                @endif
            </div>
        </div>
        
        <!-- Déjeuner Section -->
        <div id="dejeuner-section" class="menu-section" data-menu-id="{{ $menusByType['dejeuner'][0]->id ?? '' }}">
            <div class="menu-section-header">
                <div class="menu-title">
                    <i class="fa fa-cutlery section-icon"></i>
                    <h3>Déjeuner</h3>
                </div>
                <a href="{{ route('gerant.meals.create', ['menu_id' => $menusByType['dejeuner'][0]->id ?? '', 'type' => 'dejeuner']) }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Ajouter un item
                </a>
            </div>
            
            <div class="menu-items">
                @if(isset($menusByType['dejeuner']))
                    @foreach($menusByType['dejeuner'][0]->meals as $meal)
                        <div class="menu-item" data-meal-id="{{ $meal->id }}">
                            <div class="item-image">
                                @if($meal->getFirstMediaUrl('meal'))
                                    <img src="{{ $meal->getFirstMediaUrl('meal') }}" alt="{{ $meal->name }}">
                                @else
                                    <img src="{{ asset('images/placeholder-food.jpg') }}" alt="{{ $meal->name }}">
                                @endif
                            </div>
                            <div class="item-details">
                                <h4 class="item-name">{{ $meal->name }}</h4>
                                <p class="item-description">{{ $meal->description }}</p>
                            </div>
                            <div class="item-price">
                                <div class="price-circle">
                                    <span>{{ number_format($meal->price, 2) }} €</span>
                                </div>
                            </div>
                            <div class="item-actions">
                                <a href="{{ route('gerant.meals.edit', $meal->id) }}" class="action-btn edit-btn"><i class="fa fa-pencil"></i></a>
                                <button class="action-btn delete-btn" onclick="confirmDelete({{ $meal->id }})"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="no-items-message">Aucun repas pour le déjeuner. Ajoutez-en un !</p>
                @endif
            </div>
        </div>
        
        <!-- Dîner Section -->
        <div id="diner-section" class="menu-section" data-menu-id="{{ $menusByType['diner'][0]->id ?? '' }}">
            <div class="menu-section-header">
                <div class="menu-title">
                    <i class="fa fa-glass section-icon"></i>
                    <h3>Dîner</h3>
                </div>
                <a href="{{ route('gerant.meals.create', ['menu_id' => $menusByType['diner'][0]->id ?? '', 'type' => 'diner']) }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Ajouter un item
                </a>
            </div>
            
            <div class="menu-items">
                @if(isset($menusByType['diner']))
                    @foreach($menusByType['diner'][0]->meals as $meal)
                        <div class="menu-item" data-meal-id="{{ $meal->id }}">
                            <div class="item-image">
                                @if($meal->getFirstMediaUrl('meal'))
                                    <img src="{{ $meal->getFirstMediaUrl('meal') }}" alt="{{ $meal->name }}">
                                @else
                                    <img src="{{ asset('images/placeholder-food.jpg') }}" alt="{{ $meal->name }}">
                                @endif
                            </div>
                            <div class="item-details">
                                <h4 class="item-name">{{ $meal->name }}</h4>
                                <p class="item-description">{{ $meal->description }}</p>
                            </div>
                            <div class="item-price">
                                <div class="price-circle">
                                    <span>{{ number_format($meal->price, 2) }} €</span>
                                </div>
                            </div>
                            <div class="item-actions">
                                <a href="{{ route('gerant.meals.edit', $meal->id) }}" class="action-btn edit-btn"><i class="fa fa-pencil"></i></a>
                                <button class="action-btn delete-btn" onclick="confirmDelete({{ $meal->id }})"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="no-items-message">Aucun repas pour le dîner. Ajoutez-en un !</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce repas?')) {
            const form = document.getElementById('delete-form');
            form.action = "{{ route('gerant.meals.delete', '') }}/" + id;
            form.submit();
        }
    }
</script>
@endsection