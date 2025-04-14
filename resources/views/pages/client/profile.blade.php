@extends('layouts.profile')

@section('title', 'Mon Profil')

@section('content')
<div style="background: #f5f5f5; padding: 10px; margin-bottom: 20px;">
    <p>URL de l'image: {{ $user->getFirstMediaUrl('profile') }}</p>
    <p>Media count: {{ $user->getMedia('profile')->count() }}</p>
    <p>User ID: {{ $user->id }}</p>
</div>
<div class="profile-card">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->getFirstMediaUrl('profile'))
                <img src="{{ $user->getFirstMediaUrl('profile') }}" alt="Profile Image">
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Image">
            @endif
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
            <a href="{{ route('client.profile.edit') }}" class="btn btn-edit">Modifier mon profil</a>
        </div>
    </div>
</div>
@endsection