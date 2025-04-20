@extends('layouts.gerant')

@section('title', 'Ajouter un item au menu')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">Ajouter un item au menu</h2>
            <a href="{{ route('gerant.menu') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Retour au menu
            </a>
        </div>

        <div class="form-container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('gerant.meals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu_id }}">
                
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Prix (€)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image">
                    <p class="help-block">Format recommandé: JPG, PNG, GIF. Max 10MB.</p>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                    <a href="{{ route('gerant.menu') }}" class="btn btn-default">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection