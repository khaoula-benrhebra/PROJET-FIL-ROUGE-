@extends('layouts.gerant')

@section('title', 'Gestion des Tables - Gérant')

@section('content')
<div class="tables-container">
    <h1 class="page-title">Gestion des Tables</h1>

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

    <div class="tables-section">
        <div class="section-header">
            <h2>Informations du restaurant</h2>
        </div>
        
        <div class="restaurant-info">
            <p><strong>Nom:</strong> {{ $restaurant->name }}</p>
            <p><strong>Adresse:</strong> {{ $restaurant->address }}</p>
            <p><strong>Nombre de tables:</strong> {{ $restaurant->number_of_tables ?? 'Non défini' }}</p>
            <p><strong>Places par table:</strong> {{ $restaurant->seats_per_table ?? 'Non défini' }}</p>
        </div>
    </div>

    @if(count($tables) > 0)
        <div class="tables-section">
            <div class="section-header">
                <h2>Tables existantes</h2>
                <p>Nombre total de tables: {{ count($tables) }}</p>
            </div>
            
            <div class="table-list">
                @foreach($tables as $table)
                    <div class="table-card">
                        <h3>{{ $table->table_label }}</h3>
                        <div class="table-status">
                            <span class="status-indicator {{ $table->is_available ? 'status-available' : 'status-unavailable' }}"></span>
                            {{ $table->is_available ? 'Disponible' : 'Non disponible' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="tables-section">
        <div class="section-header">
            <h2>{{ count($tables) > 0 ? 'Ajouter plus de tables' : 'Créer des tables' }}</h2>
            
            @php
                $remainingTables = $restaurant->number_of_tables - count($tables);
            @endphp
            
            @if($remainingTables > 0)
                <p class="text-info">Vous pouvez encore créer {{ $remainingTables }} table(s).</p>
            @else
                <p class="text-warning">Vous avez atteint le nombre maximum de tables ({{ $restaurant->number_of_tables }}).</p>
            @endif
        </div>
        
        @if($remainingTables > 0)
            <form action="{{ route('gerant.tables.store') }}" method="POST" id="tableForm">
                @csrf
                
                <div class="table-form-container">
                    <div class="table-form-group">
                        <label>Libellés des tables</label>
                        <p class="form-text text-muted">Entrez un libellé unique pour chaque table (ex: Table 1, Table VIP, etc.)</p>
                        
                        <p id="tablesRemainingCounter" class="text-info">Vous pouvez encore ajouter {{ $remainingTables - 1 }} table(s).</p>
                        
                        <div class="table-inputs" id="tableInputs">
                            <div class="table-input-row">
                                <input type="text" name="table_labels[]" class="form-control" placeholder="Libellé de la table" required>
                                <button type="button" class="btn-remove" onclick="removeTableInput(this)" style="display: none;">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="button" class="btn-add" onclick="addTableInput()">
                            <i class="fa fa-plus"></i> Ajouter une table
                        </button>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
    const maxRemainingTables = {{ $remainingTables }};
    let currentTableCount = 1; // On commence avec un champ
    
    function addTableInput() {
       
        if (currentTableCount >= maxRemainingTables) {
            alert('Vous ne pouvez pas créer plus de ' + {{ $restaurant->number_of_tables }} + ' tables.');
            return;
        }
        
        const tableInputs = document.getElementById('tableInputs');
        const inputRow = document.createElement('div');
        inputRow.className = 'table-input-row';
        
        inputRow.innerHTML = `
            <input type="text" name="table_labels[]" class="form-control" placeholder="Libellé de la table" required>
            <button type="button" class="btn-remove" onclick="removeTableInput(this)">
                <i class="fa fa-times"></i>
            </button>
        `;
        
        tableInputs.appendChild(inputRow);
        currentTableCount++;
       
        updateTableCounter();
       
        if (tableInputs.children.length > 1) {
            const removeButtons = tableInputs.querySelectorAll('.btn-remove');
            removeButtons.forEach(button => {
                button.style.display = 'block';
            });
        }
    }
    
    function removeTableInput(button) {
        const tableInputs = document.getElementById('tableInputs');
        const row = button.parentNode;
        
        if (tableInputs.children.length > 1) {
            tableInputs.removeChild(row);
            currentTableCount--;
            
            updateTableCounter();
        }
        if (tableInputs.children.length === 1) {
            const removeButton = tableInputs.querySelector('.btn-remove');
            if (removeButton) {
                removeButton.style.display = 'none';
            }
        }
    }
    
    function updateTableCounter() {
        const counterElement = document.getElementById('tablesRemainingCounter');
        if (counterElement) {
            const remaining = maxRemainingTables - currentTableCount;
            counterElement.textContent = 'Vous pouvez encore ajouter ' + remaining + ' table(s).';
        }
    }
</script>
@endsection