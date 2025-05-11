@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    
    <div class="custom-header" style=" background-color: #f5f5f5;">
        

    </div>

    <!-- Contenu About -->
    <div id="about" class="about-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2 class="block-title">About Us</h2>
                       
                        <p>Food FunDay, C’est Parti, Tout Simplement, Comme Ça…

                            Food FunDay est né d'une passion commune pour la cuisine et l’envie de partager des moments conviviaux autour de bons repas. Dès le départ, notre mission était claire : offrir une plateforme où les restaurants et leurs clients pourraient se retrouver dans un cadre agréable et interactif.
                            
                            Dans cet espace dédié aux plaisirs gustatifs, nous croyons en la magie des saveurs, des découvertes culinaires et des échanges authentiques. Notre plateforme permet aux restaurateurs de se connecter facilement avec leurs clients, en facilitant les réservations, les commandes en ligne et les avis sur les plats.
                            
                            À travers Food FunDay, nous aspirons à créer une expérience où chaque repas devient une aventure, chaque bouchée une nouvelle découverte, et chaque instant passé dans un restaurant un moment de plaisir partagé. Nous ne faisons pas que proposer des repas, nous proposons une véritable expérience culinaire.
                            
                            Avec un service rapide et intuitif, Food FunDay réunit les amoureux de la bonne cuisine et les restaurateurs passionnés. Rejoignez-nous pour un voyage gustatif sans pareille !
                            
                            Le voyage culinaire commence ici, avec Food FunDay.</p>
                       
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <div class="about-images">
                            <img class="about-main" src="{{ asset('images/about-main.jpg') }}" alt="About Main Image">
                            <img class="about-inset" src="{{ asset('images/about-inset.jpg') }}" alt="About Inset Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection