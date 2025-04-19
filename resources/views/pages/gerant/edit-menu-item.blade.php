@extends('layouts.gerant')

@section('title', 'Modifier un plat - Gérant')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="dashboard-section">
            <h2 class="section-title">Modifier un plat</h2>
            
            <!-- Formulaire de modification de plat -->
            <div class="menu-form-container" style="max-width: 800px; margin: 0 auto;">
                <form id="menuItemForm" action="{{ route('gerant.menu') }}" method="GET">
                    <!-- Champ caché pour simuler un envoi et retour -->
                    <input type="hidden" name="edited" value="true">
                    <input type="hidden" name="id" value="{{ request('id') }}">
                    
                    <div class="form-group">
                        <label for="menuCategory">Catégorie</label>
                        <select class="form-control" id="menuCategory" name="category">
                            <option value="breakfast" {{ request('category') == 'breakfast' ? 'selected' : '' }}>Petit-déjeuner</option>
                            <option value="lunch" {{ request('category') == 'lunch' ? 'selected' : '' }}>Déjeuner</option>
                            <option value="dinner" {{ request('category') == 'dinner' ? 'selected' : '' }}>Dîner</option>
                        </select>
                    </div>
                    
                    @php
                        // Simuler la récupération des données du plat (normalement depuis la base de données)
                        $plateData = [
                            '1' => ['name' => 'Croissant Parisien', 'price' => '3.50', 'description' => 'Délicieux croissant pur beurre servi avec confiture maison.'],
                            '2' => ['name' => 'Pancakes au Sirop d\'Érable', 'price' => '7.90', 'description' => 'Stack de pancakes moelleux servis avec sirop d\'érable authentique et fruits frais.'],
                            '3' => ['name' => 'Œufs Bénédicte', 'price' => '9.50', 'description' => 'Œufs pochés sur muffin anglais avec jambon, sauce hollandaise et pommes de terre sautées.'],
                            '4' => ['name' => 'Salade César', 'price' => '11.90', 'description' => 'Laitue romaine, poulet grillé, croûtons, parmesan et sauce césar maison.'],
                            '5' => ['name' => 'Burger Gourmet', 'price' => '14.50', 'description' => 'Steak de bœuf, cheddar affiné, bacon croustillant, oignons caramélisés et frites maison.'],
                            '6' => ['name' => 'Pâtes Primavera', 'price' => '12.90', 'description' => 'Pâtes fraîches avec légumes de saison, huile d\'olive et parmesan râpé.'],
                            '7' => ['name' => 'Filet de Bœuf', 'price' => '24.90', 'description' => 'Filet de bœuf grillé, sauce au poivre, pommes de terre au four et légumes de saison.'],
                            '8' => ['name' => 'Saumon Grillé', 'price' => '21.50', 'description' => 'Filet de saumon grillé, sauce au citron et à l\'aneth, riz sauvage et asperges.'],
                            '9' => ['name' => 'Risotto aux Champignons', 'price' => '18.90', 'description' => 'Risotto crémeux aux champignons sauvages, truffe et parmesan.'],
                        ];
                        
                        $plate = $plateData[request('id')] ?? ['name' => '', 'price' => '', 'description' => ''];
                    @endphp
                    
                    <div class="form-group">
                        <label for="menuName">Nom du plat</label>
                        <input type="text" class="form-control" id="menuName" name="name" placeholder="Nom du plat" value="{{ $plate['name'] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="menuPrice">Prix (€)</label>
                        <input type="number" class="form-control" id="menuPrice" name="price" placeholder="0.00" step="0.01" value="{{ $plate['price'] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="menuDescription">Description</label>
                        <textarea class="form-control" id="menuDescription" name="description" rows="3" placeholder="Description du plat" required>{{ $plate['description'] }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="menuImage">Image (facultatif, laissez vide pour conserver l'image actuelle)</label>
                        <input type="file" class="form-control" id="menuImage" name="image">
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; margin-top: 20px;">
                        <label style="margin-right: 15px; margin-bottom: 0;">Image actuelle:</label>
                        <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                            @php
                                $images = [
                                    '1' => 'croissant.jpg',
                                    '2' => 'pancakes.jpg',
                                    '3' => 'eggs-benedict.jpg',
                                    '4' => 'caesar-salad.jpg',
                                    '5' => 'burger.jpg',
                                    '6' => 'pasta.jpg',
                                    '7' => 'steak.jpg',
                                    '8' => 'salmon.jpg',
                                    '9' => 'risotto.jpg',
                                ];
                                $image = $images[request('id')] ?? 'default.jpg';
                            @endphp
                            <img src="{{ asset('images/' . $image) }}" alt="Image actuelle" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                    <div class="form-submit" style="display: flex; justify-content: space-between; margin-top: 30px;">
                        <a href="{{ route('gerant.menu') }}?tab={{ request('category') == 'breakfast' ? '' : request('category') }}" class="menu-btn delete-menu-btn" style="text-decoration: none; display: inline-block; padding: 12px 25px;">Annuler</a>
                        <button type="submit" class="form-submit-btn">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
