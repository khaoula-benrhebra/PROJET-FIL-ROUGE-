@extends('layouts.gerant')

@section('title', 'Tableau de bord - Gérant')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-content">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="dashboard-section">
            <h2 class="section-title">Statistiques</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>{{ $todayReservationsCount ?? 0 }}</h3>
                        <p>Réservations du jour</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>{{ $expectedGuestsCount ?? 0 }}</h3>
                        <p>Clients attendus</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-cutlery" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>{{ $occupiedTablesCount ?? 0 }}</h3>
                        <p>Tables occupées</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-eur" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>{{ number_format($dailyRevenue ?? 0, 2) }} €</h3>
                        <p>Revenu journalier</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-section">
            <h2 class="section-title">Réservations récentes</h2>
            
            <div class="reservation-filters mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date-filter">Filtrer par date</label>
                            <input type="date" id="date-filter" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="reservations-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Personnes</th>
                            <th>Tables</th>
                            <th>Montant Total</th>
                            <th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($allReservations) && $allReservations->count() > 0)
                            @foreach($allReservations as $reservation)
                                <tr class="reservation-row" data-date="{{ $reservation->reservation_datetime->format('Y-m-d') }}">
                                    <td>{{ $reservation->name }}</td>
                                    <td>{{ $reservation->reservation_datetime->format('d/m/Y') }}</td>
                                    <td>{{ $reservation->reservation_datetime->format('H:i') }}</td>
                                    <td>{{ $reservation->guests }}</td>
                                    <td>
                                        @foreach($reservation->tables as $table)
                                            <span class="badge badge-info">{{ $table->table_label }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($reservation->total_amount, 2) }} €</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm view-details" data-id="{{ $reservation->id }}">Détails</button>
                                    </td>
                                </tr>
                                
                                <tr class="reservation-details details-{{ $reservation->id }}" style="display: none;">
                                    <td colspan="8">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Informations de contact</h6>
                                                        <p><strong>Email:</strong> {{ $reservation->email }}</p>
                                                        @if($reservation->phone)
                                                            <p><strong>Téléphone:</strong> {{ $reservation->phone }}</p>
                                                        @endif
                                                    </div>
                                                    
                                                    @if($reservation->special_requests)
                                                        <div class="col-md-6">
                                                            <h6>Demandes spéciales:</h6>
                                                            <p>{{ $reservation->special_requests }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($reservation->meals->count() > 0)
                                                    <div class="mt-3">
                                                        <h6>Repas commandés:</h6>
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Repas</th>
                                                                    <th>Quantité</th>
                                                                    <th>Prix unitaire</th>
                                                                    <th>Sous-total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($reservation->meals as $meal)
                                                                    <tr>
                                                                        <td>{{ $meal->name }}</td>
                                                                        <td>{{ $meal->pivot->quantity }}</td>
                                                                        <td>{{ number_format($meal->pivot->unit_price, 2) }} €</td>
                                                                        <td>{{ number_format($meal->pivot->quantity * $meal->pivot->unit_price, 2) }} €</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th colspan="3" class="text-right">Total:</th>
                                                                    <th>{{ number_format($reservation->total_amount, 2) }} €</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Aucune réservation trouvée</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

