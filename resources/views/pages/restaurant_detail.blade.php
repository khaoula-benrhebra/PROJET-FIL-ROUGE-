@extends('layouts.app')

@section('title', $restaurant->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/restaurant-detail.css') }}">
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
                    <a href="#" class="btn btn-primary"><i class="fa fa-calendar"></i> Réserver</a>
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
                    
                
                    <div class="content-section">
                        <h2>Menu</h2>
                        <div class="menu-content">
                            <p class="placeholder-text">Le menu sera bientôt disponible.</p>
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
                    
                    <div class="sidebar-section">
                        <h3>Localisation</h3>
                        <div class="map-container">
                            <div class="map-placeholder">
                                <i class="fa fa-map"></i>
                                <p>Carte interactive bientôt disponible</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sidebar-section">
                        <h3>Gérant</h3>
                        <div class="owner-info">
                            <div class="owner-avatar">
                                @if($restaurant->user->getFirstMediaUrl('profile'))
                                    <img src="{{ $restaurant->user->getFirstMediaUrl('profile') }}" alt="{{ $restaurant->user->name }}">
                                @else
                                    <div class="no-avatar">
                                        <i class="fa fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="owner-details">
                                <h4>{{ $restaurant->user->name }}</h4>
                                <p>Gérant depuis {{ $restaurant->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sidebar-section">
                        <h3>Partager</h3>
                        <div class="social-share">
                            <a href="#" class="social-btn"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="social-btn"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="social-btn"><i class="fa fa-instagram"></i></a>
                            <a href="#" class="social-btn"><i class="fa fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection