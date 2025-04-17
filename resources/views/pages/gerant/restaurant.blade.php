@extends('layouts.gerant')

@section('title', 'Mon Restaurant - Gérant')

@section('content')
<div class="restaurant-container">
    <h1 class="page-title">Mon Restaurant</h1>
    
    <div class="restaurant-section">
        <div class="section-header">
            <h2>Catégories disponibles</h2>
            <p>Sélectionnez les catégories que vous souhaitez proposer dans votre restaurant</p>
        </div>
        
        <div class="categories-list">
            @forelse($categories as $category)
                <div class="category-card">
                    <div class="category-info">
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->description ?? 'Aucune description' }}</p>
                    </div>
                    <div class="category-action">
                        <label class="toggle-switch">
                            <input type="checkbox" class="category-toggle" data-id="{{ $category->id }}">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fa fa-list"></i>
                    <p>Aucune catégorie disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection