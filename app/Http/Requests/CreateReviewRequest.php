<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateReviewRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('add_review');
    }

    public function rules()
    {
        return [
            'restaurant_id' => 'required|exists:restaurants,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ];
    }
    
    public function messages()
    {
        return [
            'restaurant_id.required' => 'L\'identifiant du restaurant est requis.',
            'restaurant_id.exists' => 'Le restaurant sélectionné n\'existe pas.',
            'rating.required' => 'La note est requise.',
            'rating.integer' => 'La note doit être un nombre entier.',
            'rating.min' => 'La note doit être au moins 1.',
            'rating.max' => 'La note ne doit pas dépasser 5.',
            'comment.required' => 'Le commentaire est requis.',
            'comment.min' => 'Le commentaire doit comporter au moins 10 caractères.',
            'comment.max' => 'Le commentaire ne doit pas dépasser 1000 caractères.',
        ];
    }
}