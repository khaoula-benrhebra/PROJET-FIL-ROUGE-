@extends('layouts.app')

@section('title', $restaurant->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/restaurant-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/restaurant-menu.css') }}">
@endsection

@section('content')
<div class="restaurant-detail-container">
    <div class="restaurant-header" 
         @if($restaurant->getFirstMediaUrl('restaurant'))
         style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('{{ $restaurant->getFirstMediaUrl('restaurant') }}');"
         @endif
          
        >
        <div class="container">
            <div class="restaurant-header-content">
                <h1>{{ $restaurant->name }}</h1>
                <div class="restaurant-meta">
                    <span class="location"><i class="fa fa-map-marker"></i> {{ $restaurant->address }}</span>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <i class="fa fa-star-o"></i>
                        <span>(0 avis)</span>
                    </div>
                </div>
                <div class="restaurant-categories">
                    @foreach($restaurant->categories as $category)
                        <span class="category-badge">{{ $category->name }}</span>
                    @endforeach
                </div>
                <div class="restaurant-actions">
                    <a href="#reservation" class="btn btn-primary"><i class="fa fa-calendar"></i> Réserver</a>
                    <a href="#" class="btn btn-outline-light"><i class="fa fa-heart-o"></i> Ajouter aux favoris</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="restaurant-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    
                    <div class="content-section">
                        <h2>À propos</h2>
                        <div class="about-content">
                            <p>{{ $restaurant->description }}</p>
                        </div>
                    </div>
                
                    <div class="content-section" id="menu-section">
                        <h2>Menu</h2>
                        
                        <div class="menu-navigation">
                            <ul class="nav menu-nav" id="restaurant-menu-tabs" role="tablist">
                                <li class="menu-nav-item active">
                                    <a href="#petit-dejeuner" class="menu-nav-link active" data-toggle="tab" role="tab">
                                        <span class="menu-icon"><i class="fa fa-coffee"></i></span>
                                        <span class="menu-text">Petit Déjeuner</span>
                                    </a>
                                </li>
                                <li class="menu-nav-item">
                                    <a href="#dejeuner" class="menu-nav-link" data-toggle="tab" role="tab">
                                        <span class="menu-icon"><i class="fa fa-cutlery"></i></span>
                                        <span class="menu-text">Déjeuner</span>
                                    </a>
                                </li>
                                <li class="menu-nav-item">
                                    <a href="#diner" class="menu-nav-link" data-toggle="tab" role="tab">
                                        <span class="menu-icon"><i class="fa fa-glass"></i></span>
                                        <span class="menu-text">Dîner</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="tab-content menu-content" id="restaurant-menu-content">
                            <div class="tab-pane fade show active" id="petit-dejeuner" role="tabpanel">
                                @if(isset($menus['petit-dejeuner']) && count($menus['petit-dejeuner']->meals) > 0)
                                    <div class="menu-items-grid">
                                        @foreach($menus['petit-dejeuner']->meals as $meal)
                                            <div class="menu-card">
                                                <div class="menu-card-img">
                                                    @if($meal->getFirstMediaUrl('meal'))
                                                        <img src="{{ $meal->getFirstMediaUrl('meal') }}" alt="{{ $meal->name }}">
                                                    @else
                                                        <div class="menu-img-placeholder">
                                                            <i class="fa fa-coffee"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="menu-card-body">
                                                    <div class="menu-card-header">
                                                        <h4 class="menu-item-title">{{ $meal->name }}</h4>
                                                        <div class="menu-item-price">{{ number_format($meal->price, 2) }} €</div>
                                                    </div>
                                                    <p class="menu-item-desc">{{ $meal->description }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="menu-empty-message">
                                        <p>Aucun plat disponible pour le petit déjeuner.</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="tab-pane fade" id="dejeuner" role="tabpanel">
                                @if(isset($menus['dejeuner']) && count($menus['dejeuner']->meals) > 0)
                                    <div class="menu-items-grid">
                                        @foreach($menus['dejeuner']->meals as $meal)
                                            <div class="menu-card">
                                                <div class="menu-card-img">
                                                    @if($meal->getFirstMediaUrl('meal'))
                                                        <img src="{{ $meal->getFirstMediaUrl('meal') }}" alt="{{ $meal->name }}">
                                                    @else
                                                        <div class="menu-img-placeholder">
                                                            <i class="fa fa-cutlery"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="menu-card-body">
                                                    <div class="menu-card-header">
                                                        <h4 class="menu-item-title">{{ $meal->name }}</h4>
                                                        <div class="menu-item-price">{{ number_format($meal->price, 2) }} €</div>
                                                    </div>
                                                    <p class="menu-item-desc">{{ $meal->description }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="menu-empty-message">
                                        <p>Aucun plat disponible pour le déjeuner.</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="tab-pane fade" id="diner" role="tabpanel">
                                @if(isset($menus['diner']) && count($menus['diner']->meals) > 0)
                                    <div class="menu-items-grid">
                                        @foreach($menus['diner']->meals as $meal)
                                            <div class="menu-card">
                                                <div class="menu-card-img">
                                                    @if($meal->getFirstMediaUrl('meal'))
                                                        <img src="{{ $meal->getFirstMediaUrl('meal') }}" alt="{{ $meal->name }}">
                                                    @else
                                                        <div class="menu-img-placeholder">
                                                            <i class="fa fa-glass"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="menu-card-body">
                                                    <div class="menu-card-header">
                                                        <h4 class="menu-item-title">{{ $meal->name }}</h4>
                                                        <div class="menu-item-price">{{ number_format($meal->price, 2) }} €</div>
                                                    </div>
                                                    <p class="menu-item-desc">{{ $meal->description }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="menu-empty-message">
                                        <p>Aucun plat disponible pour le dîner.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="content-section">
                        <h2>Avis des clients</h2>
                        <div class="reviews-content">
                            <p class="placeholder-text">Aucun avis pour le moment. Soyez le premier à donner votre avis!</p>
                            <a href="#" class="btn btn-primary">Laisser un avis</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="sidebar-section">
                        <h3>Informations</h3>
                        <ul class="info-list">
                            <li><i class="fa fa-map-marker"></i> <strong>Adresse:</strong> {{ $restaurant->address }}</li>
                            <li><i class="fa fa-phone"></i> <strong>Téléphone:</strong> Non renseigné</li>
                            <li><i class="fa fa-clock-o"></i> <strong>Horaires:</strong> Non renseignés</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-section" id="reservation">
        <h2>Réserver une table</h2>
        <div class="reservation-content">
            <form action="#" method="POST" id="reservation-form" onsubmit="event.preventDefault(); alert('Fonctionnalité non implémentée');">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nom complet *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Adresse email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="guests">Nombre de personnes *</label>
                            <select class="form-control" id="guests" name="guests" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                                @endfor
                                <option value="more">Plus de 10 personnes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="reservation_date">Date *</label>
                            <input type="date" class="form-control" id="reservation_date" name="reservation_date" required min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="reservation_time">Heure *</label>
                            <input type="time" class="form-control" id="reservation_time" name="reservation_time" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="table">Table</label>
                    <select class="form-control" id="table" name="table_id">
                        <option value="">Sélectionnez une table (optionnel)</option>
                        @if(isset($restaurant->tables) && count($restaurant->tables) > 0)
                            @foreach($restaurant->tables as $table)
                                <option value="{{ $table->id }}">{{ $table->table_label }} ({{ $restaurant->seats_per_table }} places)</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Ajouter des repas à votre réservation (optionnel)</label>
                    <div class="reservation-meals">
                        @php
                            $allMeals = collect();
                            if(isset($menus['petit-dejeuner'])) $allMeals = $allMeals->merge($menus['petit-dejeuner']->meals);
                            if(isset($menus['dejeuner'])) $allMeals = $allMeals->merge($menus['dejeuner']->meals);
                            if(isset($menus['diner'])) $allMeals = $allMeals->merge($menus['diner']->meals);
                        @endphp
                        
                        @if($allMeals->count() > 0)
                            <div class="reservation-meal-list">
                                @foreach($allMeals as $meal)
                                    <div class="reservation-meal-item">
                                        <div class="meal-info">
                                            <span class="meal-name">{{ $meal->name }}</span>
                                            <span class="meal-price">{{ number_format($meal->price, 2) }} €</span>
                                        </div>
                                        <div class="meal-quantity">
                                            <label for="meal-{{ $meal->id }}" class="sr-only">Quantité</label>
                                            <input type="number" min="0" value="0" class="form-control" id="meal-{{ $meal->id }}" name="meals[{{ $meal->id }}]">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucun repas disponible.</p>
                        @endif
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="special_requests">Requêtes spéciales</label>
                    <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Allergies, occasions spéciales, demandes particulières..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg">Confirmer la réservation</button>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
   
    const menuTabs = document.querySelectorAll('.menu-nav-link');
    
    menuTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
          
            menuTabs.forEach(t => {
                t.classList.remove('active');
                t.parentElement.classList.remove('active');
            });
           
            this.classList.add('active');
            this.parentElement.classList.add('active');
            
            const tabContents = document.querySelectorAll('.tab-pane');
            tabContents.forEach(content => {
                content.classList.remove('show', 'active');
            });
            
           
            const targetId = this.getAttribute('href');
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.classList.add('show', 'active');
            }
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endsection