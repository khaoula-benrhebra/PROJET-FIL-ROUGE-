@extends('layouts.app')

@section('title', 'Laisser un avis - ' . $restaurant->name)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review-page-header">
    <div class="container">
        <h1>Laisser un avis pour {{ $restaurant->name }}</h1>
       
    </div>
</div>

<div class="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="review-form-container">
                    <h2>Votre expérience compte</h2>
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('client.reviews.store') }}">
                        @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                        
                        <div class="form-group">
                            <label for="rating">Note</label>
                            <div class="rating-selector">
                                <div class="rating-options">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="rating-option">
                                            <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                            <label for="rating-{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="comment">Votre commentaire</label>
                            <textarea name="comment" id="comment" rows="5" class="form-control" placeholder="Partagez votre expérience...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Publier l'avis</button>
                            <a href="{{ route('restaurant.show', $restaurant->id) }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection