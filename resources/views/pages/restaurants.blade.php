@extends('layouts.app')

@section('title', 'Restaurants')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/restaurants.css') }}">
@endsection

@section('content')

<div class="custom-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>Explorez les saveurs du monde</h1>
    </div>
    <div class="header-search-box">
        <form action="#" method="GET">
            <input type="text" placeholder="Rechercher un restaurant...">
            <select>
                <option value="">Toutes les catégories</option>
                <option value="1">Cuisine Française</option>
                <option value="2">Cuisine Italienne</option>
                <option value="3">Cuisine Asiatique</option>
                <option value="4">Fast Food</option>
                <option value="5">Végétarien</option>
            </select>
            <button type="submit"><i class="fa fa-search"></i> Rechercher</button>
        </form>
    </div>
</div>

   
    <div class="restaurants-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-title">Nos restaurants partenaires</h2>
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="restaurant-card">
                        <div class="restaurant-image">
                            <img src="{{ asset('images/restaurant-01.jpg') }}" alt="Restaurant 1">
                            <div class="category-tag">Cuisine Française</div>
                        </div>
                        <div class="restaurant-content">
                            <h3>Le Gourmet Parisien</h3>
                            <div class="restaurant-info">
                                <p><i class="fa fa-map-marker"></i> 123 Avenue des Champs-Élysées, Paris</p>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <span>(120 avis)</span>
                                </div>
                            </div>
                            <p class="restaurant-description">Une cuisine française authentique dans un cadre élégant au cœur de Paris.</p>
                            <div class="restaurant-footer">
                                <a href="#" class="btn view-btn">Voir le restaurant</a>
                                <a href="#" class="btn reserve-btn">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
                
               
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="restaurant-card">
                        <div class="restaurant-image">
                            <img src="{{ asset('images/restaurant-02.jpg') }}" alt="Restaurant 2">
                            <div class="category-tag">Cuisine Italienne</div>
                        </div>
                        <div class="restaurant-content">
                            <h3>La Bella Vita</h3>
                            <div class="restaurant-info">
                                <p><i class="fa fa-map-marker"></i> 45 Rue de la République, Lyon</p>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>(98 avis)</span>
                                </div>
                            </div>
                            <p class="restaurant-description">Savourez l'authentique cuisine italienne dans une ambiance chaleureuse et familiale.</p>
                            <div class="restaurant-footer">
                                <a href="#" class="btn view-btn">Voir le restaurant</a>
                                <a href="#" class="btn reserve-btn">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
                
         
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="restaurant-card">
                        <div class="restaurant-image">
                            <img src="{{ asset('images/restaurant-03.jpg') }}" alt="Restaurant 3">
                            <div class="category-tag">Cuisine Asiatique</div>
                        </div>
                        <div class="restaurant-content">
                            <h3>Sakura Sushi</h3>
                            <div class="restaurant-info">
                                <p><i class="fa fa-map-marker"></i> 78 Rue du Commerce, Toulouse</p>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>(156 avis)</span>
                                </div>
                            </div>
                            <p class="restaurant-description">Découvrez nos délicieux sushis et plats japonais préparés par nos chefs experts.</p>
                            <div class="restaurant-footer">
                                <a href="#" class="btn view-btn">Voir le restaurant</a>
                                <a href="#" class="btn reserve-btn">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="restaurant-card">
                        <div class="restaurant-image">
                            <img src="{{ asset('images/restaurant-04.jpg') }}" alt="Restaurant 4">
                            <div class="category-tag">Fast Food</div>
                        </div>
                        <div class="restaurant-content">
                            <h3>Burger Express</h3>
                            <div class="restaurant-info">
                                <p><i class="fa fa-map-marker"></i> 22 Avenue Jean Jaurès, Bordeaux</p>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>(87 avis)</span>
                                </div>
                            </div>
                            <p class="restaurant-description">Les meilleurs burgers faits maison avec des ingrédients frais et de qualité.</p>
                            <div class="restaurant-footer">
                                <a href="#" class="btn view-btn">Voir le restaurant</a>
                                <a href="#" class="btn reserve-btn">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="restaurant-card">
                        <div class="restaurant-image">
                            <img src="{{ asset('images/restaurant-05.jpg') }}" alt="Restaurant 5">
                            <div class="category-tag">Végétarien</div>
                        </div>
                        <div class="restaurant-content">
                            <h3>Green Garden</h3>
                            <div class="restaurant-info">
                                <p><i class="fa fa-map-marker"></i> 56 Rue des Fleurs, Montpellier</p>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <span>(112 avis)</span>
                                </div>
                            </div>
                            <p class="restaurant-description">Une cuisine végétarienne inventive et savoureuse dans un cadre verdoyant.</p>
                            <div class="restaurant-footer">
                                <a href="#" class="btn view-btn">Voir le restaurant</a>
                                <a href="#" class="btn reserve-btn">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="restaurant-card">
                        <div class="restaurant-image">
                            <img src="{{ asset('images/restaurant-06.jpg') }}" alt="Restaurant 6">
                            <div class="category-tag">Cuisine Française</div>
                        </div>
                        <div class="restaurant-content">
                            <h3>La Belle Époque</h3>
                            <div class="restaurant-info">
                                <p><i class="fa fa-map-marker"></i> 89 Rue de la Paix, Nice</p>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>(93 avis)</span>
                                </div>
                            </div>
                            <p class="restaurant-description">Savourez une cuisine française raffinée dans un cadre élégant et chaleureux.</p>
                            <div class="restaurant-footer">
                                <a href="#" class="btn view-btn">Voir le restaurant</a>
                                <a href="#" class="btn reserve-btn">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="pagination-container">
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection