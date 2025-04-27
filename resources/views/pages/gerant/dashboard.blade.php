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
            <h2 class="section-title">Statistiques du {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>{{ $todayReservationsCount ?? 0 }}</h3>
                        <p>Réservations</p>
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
                    <div class="stat-icon"><i class="fa fa-eur" aria-hidden="true"></i></div>
                    <div class="stat-info">
                        <h3>{{ number_format($dailyRevenue ?? 0, 2) }} €</h3>
                        <p>Revenu journalier</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-section">
            <h2 class="section-title">Réservations du {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h2>
            
            <div class="reservation-filters mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date-filter">Changer de date</label>
                            <input type="date" id="date-filter" class="form-control" value="{{ $date }}">
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
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Aucune réservation pour cette date</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateFilter = document.getElementById('date-filter');
        
        if (dateFilter) {
            dateFilter.addEventListener('change', function() {
                const selectedDate = this.value;
                window.location.href = `{{ route('gerant.dashboard') }}?date=${selectedDate}`;
            });
        }
    });
</script>
@endsection

