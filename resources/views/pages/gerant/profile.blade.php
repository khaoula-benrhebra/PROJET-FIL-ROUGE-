@extends('layouts.gerant')

@section('title', 'Mon Profil - Gérant')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Mon Profil</h1>
        <a href="{{ route('gerant.profile.edit') }}" class="btn btn-primary">
            <i class="fa fa-pencil"></i> Modifier mon profil
        </a>
    </div>

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

    <div class="profile-content">
        <div class="profile-image-section">
            @if($user->getFirstMedia('profile'))
                <img src="{{ $user->getFirstMedia('profile')->getUrl() }}" alt="Photo de profil" class="profile-image">
            @else
                <div class="profile-image-placeholder">
                    <i class="fa fa-user"></i>
                </div>
            @endif
        </div>
        
        <div class="profile-details">
            <div class="profile-info">
                <h3>Informations personnelles</h3>
                <div class="info-item">
                    <span class="info-label">Nom :</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email :</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Rôle :</span>
                    <span class="info-value">{{ $user->role->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection