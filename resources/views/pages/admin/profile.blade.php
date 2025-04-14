@extends('layouts.admin')

@section('title', 'Mon Profil')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Mon Profil</h1>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Modifier
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
        <div class="profile-image-container">
            <div class="profile-image">
                @if($user->getFirstMedia('profile'))
                    <img src="{{ $user->getFirstMedia('profile')->getUrl() }}" alt="{{ $user->name }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>
            
            @if($user->getFirstMedia('profile'))
                <form action="{{ route('admin.profile.delete_image') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre photo de profil?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Supprimer la photo
                    </button>
                </form>
            @endif
        </div>

        <div class="profile-details">
            <div class="profile-info">
                <span class="info-label">Nom:</span>
                <span class="info-value">{{ $user->name }}</span>
            </div>
            
            <div class="profile-info">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>
            
            <div class="profile-info">
                <span class="info-label">Rôle:</span>
                <span class="info-value">{{ $user->role->name }}</span>
            </div>
            
            <div class="profile-info">
                <span class="info-label">Compte créé le:</span>
                <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-container {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    .profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border);
    }
    
    .profile-header h1 {
        color: var(--primary);
        font-size: 1.5rem;
        margin: 0;
    }
    
    .profile-content {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .profile-image-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        background-color: var(--gray);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
    }
    
    .no-image i {
        font-size: 60px;
    }
    
    .profile-details {
        flex: 1;
        min-width: 280px;
    }
    
    .profile-info {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--gray);
    }
    
    .profile-info:last-child {
        border-bottom: none;
    }
    
    .info-label {
        display: block;
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 5px;
    }
    
    .info-value {
        color: var(--text-dark);
        font-weight: 500;
        font-size: 1.1rem;
    }
    
    .alert {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border: 1px solid var(--success);
        color: var(--success);
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid var(--danger);
        color: var(--danger);
    }
</style>
@endsection