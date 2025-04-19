@extends('layouts.gerant')

@section('title', 'Ajouter un plat - Gérant')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="dashboard-section">
            <h2 class="section-title">Ajouter un nouveau plat</h2>
            
            <!-- Formulaire d'ajout de plat -->
            <div class="menu-form-container" style="max-width: 800px; margin: 0 auto;">
                <form id="menuItemForm" action="{{ route('gerant.menu') }}" method="GET">
                    <!-- Champ caché pour simuler un envoi et retour -->
                    <input type="hidden" name="added" value="true">
                    
                    <div class="form-group">
                        <label for="menuCategory">Catégorie</label>
                        <select class="form-control" id="menuCategory" name="category">
                            <option value="breakfast" {{ request('category') == 'breakfast' ? 'selected' : '' }}>Petit-déjeuner</option>
                            <option value="lunch" {{ request('category') == 'lunch' ? 'selected' : '' }}>Déjeuner</option>
                            <option value="dinner" {{ request('category') == 'dinner' ? 'selected' : '' }}>Dîner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="menuName">Nom du plat</label>
                        <input type="text" class="form-control" id="menuName" name="name" placeholder="Nom du plat" required>
                    </div>
                    <div class="form-group">
                        <label for="menuPrice">Prix (€)</label>
                        <input type="number" class="form-control" id="menuPrice" name="price" placeholder="0.00" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="menuDescription">Description</label>
                        <textarea class="form-control" id="menuDescription" name="description" rows="3" placeholder="Description du plat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="menuImage">Image</label>
                        <input type="file" class="form-control" id="menuImage" name="image">
                    </div>
                    <div class="form-submit" style="display: flex; justify-content: space-between;">
                        <a href="{{ route('gerant.menu') }}" class="menu-btn delete-menu-btn" style="text-decoration: none; display: inline-block; padding: 12px 25px;">Annuler</a>
                        <button type="submit" class="form-submit-btn">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection