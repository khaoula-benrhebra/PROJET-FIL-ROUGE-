@extends('layouts.gerant')

@section('title', 'Gestion du Menu - Gérant')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-section">
        <h2 class="section-title">Gestion du Menu</h2>
        
        <!-- Navigation rapide -->
        <div class="quick-nav">
            <a href="#petit-dejeuner-section" class="quick-nav-link">
                <i class="fa fa-coffee"></i> Petit Déjeuner
            </a>
            <a href="#dejeuner-section" class="quick-nav-link">
                <i class="fa fa-cutlery"></i> Déjeuner
            </a>
            <a href="#diner-section" class="quick-nav-link">
                <i class="fa fa-glass"></i> Dîner
            </a>
        </div>
        
        <!-- Petit Déjeuner Section -->
        <div id="petit-dejeuner-section" class="menu-section">
            <div class="menu-section-header">
                <div class="menu-title">
                    <i class="fa fa-coffee section-icon"></i>
                    <h3>Petit Déjeuner</h3>
                </div>
                <button class="btn btn-primary add-item-btn" data-meal-type="petit-dejeuner">
                    <i class="fa fa-plus"></i> Ajouter un item
                </button>
            </div>
            
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-image">
                        <img src="{{ asset('images/placeholder-food.jpg') }}" alt="Croissant">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">Croissant</h4>
                        <p class="item-description">Croissant au beurre fait maison</p>
                    </div>
                    <div class="item-price">
                        <div class="price-circle">
                            <span>2.50 €</span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                        <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                
                <div class="menu-item">
                    <div class="item-image">
                        <img src="{{ asset('images/placeholder-food.jpg') }}" alt="Café Américain">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">Café Américain</h4>
                        <p class="item-description">Café filtre</p>
                    </div>
                    <div class="item-price">
                        <div class="price-circle">
                            <span>1.50 €</span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                        <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                
                <div class="menu-item">
                    <div class="item-image">
                        <img src="{{ asset('images/placeholder-food.jpg') }}" alt="Omelette">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">Omelette</h4>
                        <p class="item-description">Omelette aux fines herbes</p>
                    </div>
                    <div class="item-price">
                        <div class="price-circle">
                            <span>6.50 €</span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                        <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Déjeuner Section -->
        <div id="dejeuner-section" class="menu-section">
            <div class="menu-section-header">
                <div class="menu-title">
                    <i class="fa fa-cutlery section-icon"></i>
                    <h3>Déjeuner</h3>
                </div>
                <button class="btn btn-primary add-item-btn" data-meal-type="dejeuner">
                    <i class="fa fa-plus"></i> Ajouter un item
                </button>
            </div>
            
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-image">
                        <img src="{{ asset('images/placeholder-food.jpg') }}" alt="Salade César">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">Salade César</h4>
                        <p class="item-description">Salade romaine, croûtons, parmesan, sauce César</p>
                    </div>
                    <div class="item-price">
                        <div class="price-circle">
                            <span>8.50 €</span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                        <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                
                <div class="menu-item">
                    <div class="item-image">
                        <img src="{{ asset('images/placeholder-food.jpg') }}" alt="Burger Maison">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">Burger Maison</h4>
                        <p class="item-description">Bœuf, cheddar, bacon, sauce spéciale</p>
                    </div>
                    <div class="item-price">
                        <div class="price-circle">
                            <span>12.90 €</span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                        <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dîner Section -->
        <div id="diner-section" class="menu-section">
            <div class="menu-section-header">
                <div class="menu-title">
                    <i class="fa fa-glass section-icon"></i>
                    <h3>Dîner</h3>
                </div>
                <button class="btn btn-primary add-item-btn" data-meal-type="diner">
                    <i class="fa fa-plus"></i> Ajouter un item
                </button>
            </div>
            
            <div class="menu-items">
                <div class="menu-item">
                    <div class="item-image">
                        <img src="{{ asset('images/placeholder-food.jpg') }}" alt="Foie Gras">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">Foie Gras</h4>
                        <p class="item-description">Foie gras maison et son chutney de figues</p>
                    </div>
                    <div class="item-price">
                        <div class="price-circle">
                            <span>14.50 €</span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                        <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                
                <div class="menu-item">
                    <div class="item-image">
                        <img src="{{ asset('images/placeholder-food.jpg') }}" alt="Filet de Bœuf">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">Filet de Bœuf</h4>
                        <p class="item-description">Sauce au poivre, pommes de terre rôties</p>
                    </div>
                    <div class="item-price">
                        <div class="price-circle">
                            <span>24.90 €</span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="action-btn edit-btn"><i class="fa fa-pencil"></i></button>
                        <button class="action-btn delete-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter/modifier un item -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addItemModalLabel">Ajouter un item au menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="menuItemForm">
                    <input type="hidden" id="mealType" name="meal_type">
                    
                    <div class="form-group">
                        <label for="itemName">Nom</label>
                        <input type="text" class="form-control" id="itemName" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="itemDescription">Description</label>
                        <textarea class="form-control" id="itemDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="itemPrice">Prix (€)</label>
                        <input type="number" step="0.01" class="form-control" id="itemPrice" name="price" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="itemCategory">Catégorie</label>
                        <select class="form-control" id="itemCategory" name="category">
                            <option value="">Sélectionner une catégorie</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="itemStatus">Statut</label>
                        <select class="form-control" id="itemStatus" name="status">
                            <option value="available">Disponible</option>
                            <option value="unavailable">Indisponible</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="itemImage">Image</label>
                        <input type="file" id="itemImage" name="image">
                        <p class="help-block">Format recommandé: JPG, PNG. Max 2MB.</p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="saveMenuItem">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
@endsection
