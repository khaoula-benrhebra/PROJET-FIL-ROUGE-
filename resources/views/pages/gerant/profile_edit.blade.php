@extends('layouts.gerant')

@section('title', 'Modifier mon profil - Gérant')

@section('content')
<div class="profile-edit-container">
    <div class="profile-header">
        <h1>Modifier mon profil</h1>
        <a href="{{ route('gerant.profile') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Retour
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="profile-edit-content">
        <form action="{{ route('gerant.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <div class="profile-image-edit">
                    <div class="current-image">
                        @if($user->getFirstMedia('profile'))
                            <img src="{{ $user->getFirstMedia('profile')->getUrl() }}" alt="Photo de profil" class="profile-image">
                            <div class="image-actions">
                                <form action="{{ route('gerant.profile.delete_image') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre image de profil ?')">
                                        <i class="fa fa-trash"></i> Supprimer l'image
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="profile-image-placeholder">
                                <i class="fa fa-user"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_image">Nouvelle image de profil</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control-file @error('profile_image') is-invalid @enderror">
                        @error('profile_image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            Formats acceptés: JPG, PNG, GIF. Taille max: 2Mo.
                        </small>
                    </div>
                </div>
                
                <div class="profile-info-edit">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection