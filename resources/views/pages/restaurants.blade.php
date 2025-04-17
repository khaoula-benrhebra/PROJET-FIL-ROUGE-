@extends('layouts.app')

@section('title', 'Restaurants')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/restaurants.css') }}">
@endsection

@section('content')

<div class="custom-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>Explorez les saveurs du monde</h1>
    </div>
    <div class="header-search-box">
        <form action="{{ route('restaurants') }}" method="GET">
            <input type="text" name="search" placeholder="Rechercher un restaurant..." value="{{ request('search') }}">
            <select name="category">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit"><i class="fa fa-search"></i> Rechercher</button>
        </form>
    </div>
</div>

<div class="restaurants-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Nos restaurants partenaires</h2>
            </div>
        </div>
        
        <div class="row">
            @forelse($restaurants as $restaurant)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="restaurant-card">
                    <div class="restaurant-image">
                        @if($restaurant->getFirstMediaUrl('restaurant'))
                            <img src="{{ $restaurant->getFirstMediaUrl('restaurant') }}" alt="{{ $restaurant->name }}">
                        @else
                            <img src="{{ asset('images/default-restaurant.jpg') }}" alt="{{ $restaurant->name }}">
                        @endif
                        <div class="category-tag">
                            {{ $restaurant->categories->first() ? $restaurant->categories->first()->name : 'Non catégorisé' }}
                        </div>
                    </div>
                    <div class="restaurant-content">
                        <h3>{{ $restaurant->name }}</h3>
                        <div class="restaurant-info">
                            <p><i class="fa fa-map-marker"></i> {{ $restaurant->address }}</p>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                                <i class="fa fa-star-o"></i>
                                <span>(0 avis)</span>
                            </div>
                        </div>
                        <p class="restaurant-description">
                            {{ Str::limit($restaurant->description, 100) ?? 'Aucune description disponible.' }}
                        </p>
                        <div class="restaurant-footer">
                            <a href="{{ route('restaurant.show', $restaurant->id) }}" class="btn view-btn">Voir le restaurant</a>
                            <a href="#" class="btn reserve-btn">Réserver</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-12">
                <div class="empty-restaurants">
                    <i class="fa fa-utensils"></i>
                    <h3>Aucun restaurant trouvé</h3>
                    <p>Essayez de modifier vos critères de recherche ou revenez plus tard.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        @if(isset($restaurants) && method_exists($restaurants, 'links'))
        <div class="row">
            <div class="col-lg-12">
                <div class="pagination-container">
                    {{ $restaurants->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection