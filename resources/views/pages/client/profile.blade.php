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

    <!-- Section des réservations en tableau -->
    @if($user->role->name === 'Client' && isset($reservations))
        <div class="reservation-history-section">
            <h2 class="reservation-title">Historique de mes réservations</h2>

            @if(count($reservations) > 0)
                <div class="table-responsive">
                    <table class="reservation-table">
                        <thead>
                            <tr>
                                <th>Restaurant</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Personnes</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->restaurant->name }}</td>
                                    <td>{{ $reservation->reservation_datetime->format('d/m/Y') }}</td>
                                    <td>{{ $reservation->reservation_datetime->format('H:i') }}</td>
                                    <td>{{ $reservation->guests }}</td>
                                    <td>
                                        <span class="status-badge {{ $reservation->isConfirmed() ? 'confirmed' : 'pending' }}">
                                            {{ $reservation->isConfirmed() ? 'Confirmée' : 'En attente' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-reservations">
                    <p>Vous n'avez aucune réservation pour le moment.</p>
                    <a href="{{ route('restaurants') }}" class="btn-discover">Découvrir nos restaurants</a>
                </div>
            @endif
        </div>
    @endif
@endsection