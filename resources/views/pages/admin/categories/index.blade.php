@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Gestion des Catégories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Catégorie
        </a>
    </div>

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

    <div class="table-container">
        @if($categories->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description ?? 'Aucune description' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="action-btn delete" 
                                            onclick="confirmDelete('{{ $category->id }}', '{{ $category->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-list"></i>
                <p>Aucune catégorie trouvée. Commencez par en créer une !</p>
            </div>
        @endif
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer la catégorie <span id="categoryName"></span> ?</p>
            <div class="modal-actions">
                <button id="cancelDelete" class="btn btn-secondary">Annuler</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(id, name) {
        document.getElementById('categoryName').textContent = name;
        document.getElementById('deleteForm').action = "{{ url('admin/categories') }}/" + id;
        
     
        const modal = document.getElementById('deleteModal');
        modal.style.display = "block";
        
       
        document.getElementsByClassName('close')[0].onclick = function() {
            modal.style.display = "none";
        }
        
        document.getElementById('cancelDelete').onclick = function() {
            modal.style.display = "none";
        }
        
      
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
</script>
@endsection

@section('styles')
<style>
    .empty-state {
        text-align: center;
        padding: 40px 0;
        color: var(--text-light);
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 10px;
    }
 
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 50%;
        max-width: 500px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close:hover {
        color: black;
    }
    
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
        gap: 10px;
    }
    
    .btn-danger {
        background-color: var(--danger);
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
@endsection