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
                        <span class="rating-text">{{ number_format($restaurant->average_rating, 1) }}/5</span>
                        <span class="review-count">({{ $restaurant->reviews->count() }} avis)</span>
                    </div>
                </div>
                <div class="restaurant-categories">
                    @foreach($restaurant->categories as $category)
                        <span class="category-badge">{{ $category->name }}</span>
                    @endforeach
                </div>
                <div class="restaurant-actions">
                    <a href="{{ route('client.reservations.create', ['restaurant_id' => $restaurant->id]) }}" class="btn btn-primary"><i class="fa fa-calendar"></i> Réserver</a>
                    <a href="#" class="btn btn-outline-light"><i class="fa fa-heart-o"></i> Ajouter aux favoris</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="restaurant-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- À propos -->
                    <div class="content-section">
                        <h2>À propos</h2>
                        <div class="about-content">
                            <p>{{ $restaurant->description }}</p>
                        </div>
                    </div>
                    
                    <!-- Menu Section -->
                    <div class="content-section" id="menu-section">
                        <h2>Menu</h2>
                        
                        <!-- Menu Navigation -->
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
                        
                        <!-- Menu Content -->
                        <div class="tab-content menu-content" id="restaurant-menu-content">
                            <!-- Petit Déjeuner -->
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
                            
                            <!-- Déjeuner -->
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
                            
                            <!-- Dîner -->
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
                    
                    <!-- Avis Section -->
                    <div class="content-section" id="reviews-section">
                        <h2>Avis des clients</h2>
                        <div class="reviews-content">
                            @if($restaurant->reviews->count() > 0)
                                <div class="reviews-summary">
                                    <div class="average-rating">
                                        <span class="rating-value">{{ number_format($restaurant->average_rating, 1) }}</span>
                                        <span class="rating-max">/5</span>
                                    </div>
                                    <div class="rating-count">
                                        <span>{{ $restaurant->reviews->count() }} avis</span>
                                    </div>
                                </div>
                                
                                <div class="reviews-list">
                                    @foreach($restaurant->reviews as $review)
                                        <div class="review-card">
                                            <div class="review-header">
                                                <div class="reviewer-info">
                                                    <div class="reviewer-avatar">
                                                        @if($review->user->getFirstMediaUrl('profile'))
                                                            <img src="{{ $review->user->getFirstMediaUrl('profile') }}" alt="{{ $review->user->name }}">
                                                        @else
                                                            <div class="avatar-placeholder">
                                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="reviewer-name">
                                                        <h4>{{ $review->user->name }}</h4>
                                                        <span class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="review-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fa fa-star"></i>
                                                        @else
                                                            <i class="fa fa-star-o"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="review-body">
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="placeholder-text">Aucun avis pour le moment. Soyez le premier à donner votre avis!</p>
                            @endif
                            
                            @auth
                                <a href="{{ route('client.reviews.create', ['restaurant_id' => $restaurant->id]) }}" class="btn btn-primary">Laisser un avis</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Connectez-vous pour laisser un avis</a>
                            @endauth
                        </div>
                    </div>
                </div>
                
               
            </div>
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
});
</script>
@endsection