
@extends('layouts.profile')

@section('title', 'Mon Profil')

@section('content')
<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="{{ asset('images/default-profile.png') }}" alt="Profile Image">
        </div>
        <h1 class="profile-name">{{ $user->name }}</h1>
        <p class="profile-role">{{ $user->role->name }}</p>
    </div>
    
    <div class="profile-body">
        <div class="profile-info">
            <h2 class="info-title">Informations personnelles</h2>
            
            <div class="info-item">
                <div class="info-label">Nom complet:</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Membre depuis:</div>
                <div class="info-value">{{ $user->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
        
        <div class="profile-actions">
            <a href="#" class="btn btn-edit">Modifier mon profil</a>
        </div>
    </div>
</div>
@endsection