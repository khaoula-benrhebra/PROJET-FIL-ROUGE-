@extends('layouts.app')

@section('title', 'Réservation')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection

@section('content')
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
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                <div class="reservation-form-box">
                    <form id="reservation-form" method="post" class="reservations-box" action="{{ route('client.reservations.store') }}">
                        @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="name">Nom*</label>
                                    <input type="text" name="name" id="name" placeholder="Votre nom complet" required value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="email">Email*</label>
                                    <input type="email" name="email" id="email" placeholder="Votre adresse email" required value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="phone">Téléphone</label>
                                    <input type="text" name="phone" id="phone" placeholder="Votre numéro de téléphone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="guests">Nombre de personnes*</label>
                                    <div class="input-group guests-input-group">
                                        <input type="number" name="guests" id="guests" class="form-control" placeholder="Nombre de personnes" required min="1" max="20" value="{{ old('guests') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-users"></i></span>
                                        </div>
                                    </div>
                                    @error('guests')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="reservation_date">Date de réservation*</label>
                                    <div class="input-group date-picker-group">
                                        <input type="text" name="reservation_date" id="reservation_date" class="form-control date-picker" placeholder="JJ/MM/AAAA" required value="{{ old('reservation_date') }}" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    @error('reservation_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label for="reservation_time">Heure de réservation*</label>
                                    <div class="input-group time-picker-group">
                                        <input type="text" name="reservation_time" id="reservation_time" class="form-control time-picker" placeholder="HH:MM" required value="{{ old('reservation_time') }}" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                    @error('reservation_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bouton de recherche des tables disponibles centré -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="button" id="search-tables-btn" class="btn-search-tables">
                                    <i class="fa fa-search"></i> Rechercher des tables disponibles
                                </button>
                            </div>
                        </div>
                        
                        <div class="row mt-4" id="tables-container" style="display: none;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <label>Tables disponibles*</label>
                                    <div id="available-tables">
                                        <!-- Les tables disponibles seront chargées ici -->
                                    </div>
                                    @error('tables')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('tables.*')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
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
                                        <input type="hidden" name="meals[{{ $meal->id }}][price]" value="{{ $meal->price }}">
                                        <label for="meal_{{ $meal->id }}">Quantité:</label>
                                        <select name="meals[{{ $meal->id }}][quantity]" id="meal_{{ $meal->id }}" class="form-control quantity-select">
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
                                    <label for="special_requests">Demandes spéciales</label>
                                    <textarea name="special_requests" id="special_requests" placeholder="Instructions spéciales, demandes particulières, allergies...">{{ old('special_requests') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="reservation-total-box text-right">
                                    <h4>Montant total : <span id="reservation-total">0.00</span> €</h4>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
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
                    <img src="{{ asset('images/table2.jpeg') }}" alt="Réservation" class="img-fluid">
                </div>
                
                <div class="reservation-info-card mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-info-circle"></i> Informations sur la réservation</h5>
                        </div>
                        <div class="card-body">
                            <ul class="reservation-info-list">
                                <li><i class="fa fa-clock"></i> Chaque réservation dure 2 heures</li>
                                <li><i class="fa fa-calendar-check"></i> Les réservations doivent être effectuées au moins 2 heures à l'avance</li>
                                <li><i class="fa fa-calendar-times"></i> Les jours grisés dans le calendrier sont complets</li>
                                <li><i class="fa fa-utensils"></i> La sélection de repas est optionnelle</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chargement de Flatpickr depuis CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
<script src="{{ asset('js/reservation.js') }}"></script>
@endsection