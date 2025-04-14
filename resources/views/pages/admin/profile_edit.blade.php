@extends('layouts.admin')

@section('title', 'Modifier Profil')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Modifier Mon Profil</h1>
        <a href="{{ route('admin.profile') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <label>Photo de profil actuelle</label>
            <div class="current-profile-image">
                @if($user->getFirstMedia('profile'))
                    <div class="image-container">
                        <img src="{{ $user->getFirstMedia('profile')->getUrl() }}" alt="{{ $user->name }}">
                    </div>
                @else
                    <div class="no-image">
                        <i class="fas fa-user"></i>
                        <p>Aucune image de profil</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="profile_image">Changer la photo de profil</label>
            <div class="custom-file-input">
                <input type="file" id="profile_image" name="profile_image" class="form-control-file" accept="image/*">
                <div class="input-preview">
                    <i class="fas fa-upload"></i>
                    <span id="file-name">Choisir un fichier</span>
                </div>
            </div>
            <small class="form-text text-muted">Formats acceptés: JPG, JPEG, PNG, GIF. Taille maximale: 2MB.</small>
        </div>
    
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
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
    
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }
    
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 10px;
    }
    
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(231, 91, 30, 0.25);
    }
    
    .current-profile-image {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }
    
    .image-container {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
    }
    
    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: var(--gray);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
    }
    
    .no-image i {
        font-size: 30px;
        margin-bottom: 5px;
    }
    
    .no-image p {
        font-size: 12px;
        text-align: center;
    }
    
    .custom-file-input {
        position: relative;
    }
    
    .custom-file-input input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .input-preview {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        background-color: var(--bg-light);
        border: 1px dashed var(--border);
        border-radius: 4px;
        cursor: pointer;
    }
    
    .input-preview i {
        margin-right: 10px;
        color: var(--primary);
    }
    
    .form-text {
        margin-top: 5px;
        font-size: 0.85rem;
    }
    
    .form-actions {
        margin-top: 30px;
        display: flex;
        justify-content: flex-end;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .btn i {
        margin-right: 8px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-hover);
    }
    
    .btn-secondary {
        background-color: var(--text-light);
        color: white;
    }
    
    .btn-secondary:hover {
        background-color: var(--text-dark);
    }
    
    .alert {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid var(--danger);
        color: var(--danger);
    }
    
    .alert ul {
        margin: 0;
        padding-left: 20px;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('profile_image');
        const fileNameDisplay = document.getElementById('file-name');
        
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Choisir un fichier';
            }
        });
    });
</script>
@endsection