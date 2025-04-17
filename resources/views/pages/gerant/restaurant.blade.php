@extends('layouts.gerant')

@section('title', 'Mon Restaurant - Gérant')

@section('content')
<div class="restaurant-container">
    <h1 class="page-title">Mon Restaurant</h1>

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

    @if(isset($restaurant) && $restaurant)
        <!-- Restaurant existant -->
        <div class="restaurant-section">
            <div class="section-header">
                <h2>Informations du restaurant</h2>
                <a href="{{ route('gerant.restaurant.edit') }}" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Modifier mon restaurant
                </a>
            </div>
            
            <div class="restaurant-card">
                <div class="restaurant-image">
                    @if($restaurant->getFirstMediaUrl('restaurant'))
                        <img src="{{ $restaurant->getFirstMediaUrl('restaurant') }}" alt="{{ $restaurant->name }}">
                    @else
                        <div class="no-image">
                            <i class="fa fa-image"></i>
                            <p>Aucune image</p>
                        </div>
                    @endif
                </div>
                <div class="restaurant-details">
                    <h3>{{ $restaurant->name }}</h3>
                    <p><i class="fa fa-map-marker"></i> {{ $restaurant->address }}</p>
                    <div class="restaurant-description">
                        <p>{{ $restaurant->description }}</p>
                    </div>
                    
                    <div class="restaurant-categories">
                        <h4>Catégories</h4>
                        <div class="category-tags">
                            @foreach($restaurant->categories as $category)
                                <span class="category-tag">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Pas de restaurant, montrer un formulaire de création -->
        <div class="restaurant-section">
            <div class="section-header">
                <h2>Créer mon restaurant</h2>
                <p>Veuillez remplir le formulaire ci-dessous pour créer votre restaurant</p>
            </div>
            
            <form action="{{ route('gerant.restaurant.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nom du restaurant *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="address">Adresse *</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image">Image du restaurant</label>
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
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
                                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
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
                        <i class="fa fa-save"></i> Créer mon restaurant
                    </button>
                </div>
            </form>
        </div>
    @endif
    
    <div class="restaurant-section">
        <div class="section-header">
            <h2>Catégories disponibles</h2>
            <p>Liste des catégories disponibles pour votre restaurant</p>
        </div>
        
        <div class="categories-list">
            @forelse($categories as $category)
                <div class="category-card">
                    <div class="category-info">
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->description ?? 'Aucune description' }}</p>
                    </div>
                    @if(isset($restaurant) && $restaurant)
                        <div class="category-action">
                            <label class="toggle-switch">
                                <input type="checkbox" class="category-toggle" data-id="{{ $category->id }}" 
                                    {{ $restaurant->categories->contains('id', $category->id) ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    @endif
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Traitement des toggles des catégories
        const toggles = document.querySelectorAll('.category-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const categoryId = this.dataset.id;
                const isChecked = this.checked;
                
                // Envoyer une requête AJAX pour mettre à jour les catégories
                fetch('{{ route("gerant.restaurant.toggle-category") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        category_id: categoryId,
                        checked: isChecked
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Succès
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'alert alert-success';
                        messageDiv.textContent = data.message;
                        
                        const container = document.querySelector('.restaurant-container');
                        container.insertBefore(messageDiv, container.firstChild);
                        
                        // Faire disparaître le message après 3 secondes
                        setTimeout(() => {
                            messageDiv.remove();
                        }, 3000);
                    } else {
                        // Erreur
                        alert(data.message || 'Une erreur est survenue');
                        // Remettre le toggle dans son état précédent
                        this.checked = !isChecked;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue');
                    // Remettre le toggle dans son état précédent
                    this.checked = !isChecked;
                });
            });
        });
    });
</script>
@endsection