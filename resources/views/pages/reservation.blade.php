@extends('layouts.app')

@section('title', 'Réservation')

@section('content')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection
<!-- Reservation Section -->
<div class="reservation-main pad-top-100 pad-bottom-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                    <h2 class="block-title text-center">Réservation</h2>
                    <p class="title-caption text-center">Réservez votre table et sélectionnez vos plats préférés</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mx-auto">
                <div class="reservation-form-box">
                    <form id="reservation-form" method="get" class="reservations-box" name="reservationform" action="#">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="name">Nom*</label>
                                    <input type="text" name="name" id="name" placeholder="Votre nom complet" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="email">Email*</label>
                                    <input type="email" name="email" id="email" placeholder="Votre adresse email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="phone">Téléphone*</label>
                                    <input type="text" name="phone" id="phone" placeholder="Votre numéro de téléphone" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="no_of_persons">Nombre de personnes*</label>
                                    <select name="no_of_persons" id="no_of_persons" class="selectpicker" required>
                                        <option value="" disabled selected>Sélectionnez le nombre</option>
                                        <option value="1">1 personne</option>
                                        <option value="2">2 personnes</option>
                                        <option value="3">3 personnes</option>
                                        <option value="4">4 personnes</option>
                                        <option value="5">5 personnes</option>
                                        <option value="6">6 personnes</option>
                                        <option value="7">7 personnes</option>
                                        <option value="8">8 personnes ou plus</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="date">Date de réservation*</label>
                                    <input type="text" name="date" id="date" class="datepicker" placeholder="JJ/MM/AAAA" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="time">Heure de réservation*</label>
                                    <input type="text" name="time" id="time" class="timepicker" placeholder="HH:MM" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="table_choice">Choix de table*</label>
                                    <select name="table_choice" id="table_choice" class="selectpicker" required>
                                        <option value="" disabled selected>Sélectionnez une table</option>
                                        <option value="standard">Table standard</option>
                                        <option value="window">Table près de la fenêtre</option>
                                        <option value="terrace">Table en terrasse</option>
                                        <option value="private">Table privée</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <h4 class="meal-title">Choix de repas</h4>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row meal-selection">
                            @foreach($meals as $meal)
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="meal-item">
                                    <div class="meal-info">
                                        <h5>{{ $meal->name }}</h5>
                                        <p>{{ $meal->description }}</p>
                                        <span class="meal-price">{{ $meal->price }} €</span>
                                    </div>
                                    <div class="meal-quantity">
                                        <label for="meal_{{ $meal->id }}">Quantité:</label>
                                        <select name="meals[{{ $meal->id }}]" id="meal_{{ $meal->id }}" class="quantity-select">
                                            <option value="0" selected>0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="message">Message personnalisé</label>
                                    <textarea name="message" id="message" placeholder="Instructions spéciales, demandes particulières, allergies..."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="reserve-book-btn text-center">
                                    <button class="hvr-underline-from-center" type="submit" id="submit">Réserver Ma Table</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 d-none d-md-block">
                <div class="reservation-image">
                    <img src="{{ asset('images/food-image.jpg') }}" alt="Réservation" class="img-fluid">
                    <div class="reservation-info">
                        <h3>Pourquoi réserver?</h3>
                        <ul>
                            <li><i class="fa fa-check"></i> Évitez les files d'attente</li>
                            <li><i class="fa fa-check"></i> Garantissez votre place</li>
                            <li><i class="fa fa-check"></i> Commandez à l'avance</li>
                            <li><i class="fa fa-check"></i> Service personnalisé</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialisation des datepickers
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            startDate: 'today',
            language: 'fr'
        });
        
        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: '10:00',
            maxTime: '22:00',
            defaultTime: '12:00',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        
        // Activation des selects bootstrap
        $('.selectpicker').selectpicker();
    });
</script>
@endsection