@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Banner -->
    <div id="banner" class="banner full-screen-mode parallax">
        <div class="container pr">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner-static">
                    <div class="banner-text">
                        <div class="banner-cell">
                            <h1>Dinner with us <span class="typer" id="some-id" data-delay="200" data-delim=":"
                                    data-words="Friends:Family:Officemates" data-colors="red"></span><span class="cursor"
                                    data-cursorDisplay="_" data-owner="some-id"></span></h1>
                            <h2>Accidental appearances</h2>
                            <div class="book-btn">
                                <a href="#reservation" class="table-btn hvr-underline-from-center">Book my Table</a>
                            </div>
                            <a href="#gallery">
                                <div class="mouse"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ajoutez cette section où vous voulez afficher les meilleurs restaurants -->
<div class="restaurants-section pad-top-100 pad-bottom-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                    <h2 class="block-title text-center">Nos meilleurs restaurants</h2>
                    <p class="title-caption text-center">Découvrez les restaurants les plus populaires choisis par nos clients</p>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($topRestaurants as $restaurant)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="restaurant-card">
                        <div class="restaurant-image">
                            @if($restaurant->getFirstMediaUrl('restaurant'))
                                <img src="{{ $restaurant->getFirstMediaUrl('restaurant') }}" alt="{{ $restaurant->name }}">
                            @else
                                <img src="{{ asset('images/default-restaurant.jpg') }}" alt="{{ $restaurant->name }}">
                            @endif
                            <div class="category-tag">
                                {{ $restaurant->categories->first() ? $restaurant->categories->first()->name : 'Non catégorisé' }}
                            </div>
                        </div>
                        <div class="restaurant-content">
                            <h3>{{ $restaurant->name }}</h3>
                            <div class="restaurant-info">
                                <p><i class="fa fa-map-marker"></i> {{ $restaurant->address }}</p>
                                <div class="rating">
                                    <span class="rating-text">
                                        @if(isset($restaurant->average_rating))
                                            {{ number_format($restaurant->average_rating, 1) }}
                                        @else
                                            0.0
                                        @endif
                                        /5
                                    </span>
                                    <span class="review-count">({{ $restaurant->reviews->count() ?? 0 }} avis)</span>
                                </div>
                            </div>
                            <p class="restaurant-description">
                                {{ Str::limit($restaurant->description, 100) ?? 'Aucune description disponible.' }}
                            </p>
                            <div class="restaurant-footer">
                                <a href="{{ route('restaurant.show', $restaurant->id) }}" class="btn view-btn">Voir le
                                    restaurant</a>
                                <a href="{{ route('client.reservations.create', ['restaurant_id' => $restaurant->id]) }}"
                                    class="btn reserve-btn">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <div class="empty-restaurants">
                        <i class="fa fa-utensils"></i>
                        <h3>Pas encore de restaurant</h3>
                        <p>Soyez le premier à ajouter votre restaurant.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="row mt-4">
            <div class="col-lg-12 text-center">
                <a href="{{ route('restaurants') }}" class="btn btn-primary">Voir tous les restaurants</a>
            </div>
        </div>
    </div>
</div>

    <!-- Gallery -->
    <div id="gallery" class="gallery-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2 class="block-title text-center">Our Gallery</h2>
                        <p class="title-caption text-center">Une variété de repas issus de plusieurs pays pour un voyage culinaire unique.
                        </p>
                    </div>
                    <div class="gal-container clearfix">
                        <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#1"><img
                                        src="{{ asset('images/gallery_01.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="1" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_01.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 1 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#2"><img
                                        src="{{ asset('images/gallery_02.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="2" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_02.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 2 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#3"><img
                                        src="{{ asset('images/gallery_03.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="3" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_03.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 3 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#4"><img
                                        src="{{ asset('images/image4.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="4" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/image4.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 4 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#5"><img
                                        src="{{ asset('images/gallery_05.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="5" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_05.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 5 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#9"><img
                                        src="{{ asset('images/gallery_06.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="9" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_06.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 6 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#10"><img
                                        src="{{ asset('images/gallery_07.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="10" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_07.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 7 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#11"><img
                                        src="{{ asset('images/gallery_08.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="11" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_08.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 8 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#12"><img
                                        src="{{ asset('images/gallery_09.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="12" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_09.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 9 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                            <div class="box">
                                <a href="#" data-toggle="modal" data-target="#13"><img
                                        src="{{ asset('images/gallery_10.jpg') }}" alt="" /></a>
                                <div class="modal fade" id="13" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <div class="modal-body"><img src="{{ asset('images/gallery_10.jpg') }}"
                                                    alt="" /></div>
                                            <div class="col-md-12 description">
                                                <h4>This is the 10 one on my Gallery</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection