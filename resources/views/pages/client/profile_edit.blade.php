@extends('layouts.profile')

@section('title', 'Modifier mon profil')

@section('content')
<div class="profile-card">
    <div class="profile-header">
        <h1>Modifier mon profil</h1>
    </div>
    
    <div class="profile-body">
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
        
        <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="profile_image">Image de profil</label>
                <div class="current-image mb-2">
                    @if($user->getFirstMediaUrl('profile'))
                        <img src="{{ $user->getFirstMediaUrl('profile') }}" alt="Image de profil actuelle" class="img-thumbnail" style="max-width: 200px;">
                        <form action="{{ route('client.profile.delete_image') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer l'image</button>
                        </form>
                    @else
                        <p>Aucune image de profil</p>
                    @endif
                </div>
                <input type="file" id="profile_image" name="profile_image" class="form-control-file @error('profile_image') is-invalid @enderror">
                @error('profile_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Format accepté: jpeg, png, jpg, gif. Taille max: 2Mo.</small>
            </div>
            
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="{{ route('client.profile') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection