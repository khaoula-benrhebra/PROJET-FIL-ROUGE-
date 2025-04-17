@extends('layouts.gerant')

@section('title', 'Modifier Mon Restaurant - Gérant')

@section('content')
<div class="restaurant-container">
    <h1 class="page-title">Modifier Mon Restaurant</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="restaurant-section">
        <div class="section-header">
            <h2>Informations du restaurant</h2>
            <a href="{{ route('gerant.restaurant.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Retour
            </a>
        </div>
        
        <form action="{{ route('gerant.restaurant.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Nom du restaurant *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $restaurant->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="address">Adresse *</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $restaurant->address) }}" required>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $restaurant->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Image actuelle</label>
                <div class="current-image">
                    @if($restaurant->getFirstMediaUrl('restaurant'))
                        <img src="{{ $restaurant->getFirstMediaUrl('restaurant') }}" alt="{{ $restaurant->name }}" class="img-thumbnail">
                        <div class="image-actions">
                            <label for="image" class="btn btn-sm btn-primary">Changer l'image</label>
                        </div>
                    @else
                        <div class="no-image">
                            <i class="fa fa-image"></i>
                            <p>Aucune image</p>
                        </div>
                    @endif
                </div>
                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" style="display: none;">
                <small class="form-text text-muted">Format recommandé: JPG, PNG (max: 2Mo)</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Catégories *</label>
                <div class="categories-selection">
                    @foreach($categories as $category)
                        <div class="category-checkbox">
                            <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}" 
                                {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                            <label for="category-{{ $category->id }}">
                                {{ $category->name }}
                                <small>{{ $category->description ?? '' }}</small>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('categories')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('gerant.restaurant.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('image').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Aucun fichier sélectionné';
            this.nextElementSibling.textContent = fileName;
        });
    });
</script>
@endsection