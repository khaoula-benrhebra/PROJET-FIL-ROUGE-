@extends('layouts.profile')

@section('title', 'Mon Profil')

@section('content')

<div class="profile-card">
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
    
    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->getFirstMediaUrl('profile'))
                <img src="{{ $user->getFirstMediaUrl('profile') }}" alt="Profile Image">
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Image">
            @endif
        </div>
        <h1 class="profile-name">{{ $user->name }}</h1>
        <p class="profile-role">{{ $user->role->name }}</p>
    </div>
    
    <div class="profile-body">
        <div class="profile-info">
            <h2 class="info-title">Informations personnelles</h2>
            
            <div class="info-item">
                <div class="info-label">Nom complet:</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Membre depuis:</div>
                <div class="info-value">{{ $user->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
        
        <div class="profile-actions">
            <a href="{{ route('client.profile.edit') }}" class="btn btn-edit">Modifier mon profil</a>
        </div>
    </div>
</div>

<!-- Section des réservations -->
@if($user->role->name === 'Client' && isset($reservations))
<div class="profile-reservations mt-4">
    <h2 class="section-title">Mes réservations</h2>
    
    @if(count($reservations) > 0)
        <div class="reservation-list">
            @foreach($reservations as $reservation)
                <div class="reservation-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $reservation->restaurant->name }}</h5>
                        <span class="reservation-status 
                            @if($reservation->isPending()) badge badge-warning
                            @elseif($reservation->isConfirmed()) badge badge-success
                            @elseif($reservation->isCanceled()) badge badge-danger
                            @elseif($reservation->isCompleted()) badge badge-secondary
                            @endif">
                            @if($reservation->isPending()) En attente
                            @elseif($reservation->isConfirmed()) Confirmée
                            @elseif($reservation->isCanceled()) Annulée
                            @elseif($reservation->isCompleted()) Terminée
                            @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="reservation-details">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><i class="fa fa-calendar"></i> <strong>Date:</strong> {{ $reservation->reservation_datetime->format('d/m/Y') }}</p>
                                    <p><i class="fa fa-clock-o"></i> <strong>Heure:</strong> {{ $reservation->reservation_datetime->format('H:i') }}</p>
                                    <p><i class="fa fa-users"></i> <strong>Personnes:</strong> {{ $reservation->guests }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="fa fa-cutlery"></i> <strong>Tables:</strong>
                                        @foreach($reservation->tables as $table)
                                            <span class="badge badge-info">{{ $table->table_label }}</span>
                                        @endforeach
                                    </p>
                                    @if($reservation->special_requests)
                                        <p><i class="fa fa-comment"></i> <strong>Demandes spéciales:</strong> {{ $reservation->special_requests }}</p>
                                    @endif
                                    <p><i class="fa fa-eur"></i> <strong>Montant total:</strong> {{ number_format($reservation->total_amount, 2) }} €</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($reservation->meals->count() > 0)
                            <div class="reservation-meals mt-3">
                                <h6>Repas commandés</h6>
                                <ul class="list-group">
                                    @foreach($reservation->meals as $meal)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $meal->name }}
                                            <div>
                                                <span class="badge badge-primary badge-pill">{{ $meal->pivot->quantity }} x</span>
                                                <span class="meal-price">{{ number_format($meal->pivot->unit_price, 2) }} €</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-right">
                        @if($reservation->isPending() || $reservation->isConfirmed())
                            @php
                                $reservationDateTime = clone $reservation->reservation_datetime;
                                $canCancel = $reservationDateTime->subHours(24)->isFuture();
                            @endphp
                            
                            @if($canCancel)
                                <button class="btn btn-danger btn-sm cancel-reservation" data-id="{{ $reservation->id }}">Annuler</button>
                            @else
                                <button class="btn btn-danger btn-sm" disabled>Annulation impossible (< 24h)</button>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <p>Vous n'avez aucune réservation pour le moment.</p>
            <a href="{{ route('restaurants') }}" class="btn btn-primary mt-2">Découvrir nos restaurants</a>
        </div>
    @endif
</div>

<!-- Modal de confirmation d'annulation -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Confirmer l'annulation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir annuler cette réservation ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non, garder ma réservation</button>
                <form id="cancel-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Oui, annuler ma réservation</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cancelButtons = document.querySelectorAll('.cancel-reservation');
        const cancelForm = document.getElementById('cancel-form');
        
        if (cancelButtons.length > 0 && cancelForm) {
            cancelButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const reservationId = this.dataset.id;
                    cancelForm.action = `/client/reservations/${reservationId}/cancel`;
                    $('#cancelModal').modal('show');
                });
            });
        }
    });
</script>
@endsection