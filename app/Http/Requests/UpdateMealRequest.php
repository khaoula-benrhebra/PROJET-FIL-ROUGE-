<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateMealRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('update_meals');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,unavailable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Le nom du repas est requis.',
            'name.max' => 'Le nom du repas ne doit pas dépasser 255 caractères.',
            'price.required' => 'Le prix du repas est requis.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix ne peut pas être négatif.',
            'status.required' => 'Le statut du repas est requis.',
            'status.in' => 'Le statut doit être disponible ou indisponible.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être de type: jpeg, png, jpg ou gif.',
            'image.max' => 'L\'image ne doit pas dépasser 10Mo.'
        ];
    }
}