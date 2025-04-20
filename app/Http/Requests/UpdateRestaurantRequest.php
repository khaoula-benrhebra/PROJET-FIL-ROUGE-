<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('update_restaurant');
    }

    public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'description' => 'nullable|string',
        'number_of_tables' => 'required|integer|min:1',
        'seats_per_table' => 'required|integer|min:1|max:20',
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
    ];
}
    
public function messages()
{
    return [
        'name.required' => 'Le nom du restaurant est requis.',
        'name.max' => 'Le nom du restaurant ne doit pas dépasser 255 caractères.',
        'address.required' => 'L\'adresse du restaurant est requise.',
        'address.max' => 'L\'adresse ne doit pas dépasser 255 caractères.',
        'categories.required' => 'Veuillez sélectionner au moins une catégorie.',
        'categories.*.exists' => 'Une des catégories sélectionnées n\'existe pas.',
        'image.image' => 'Le fichier doit être une image.',
        'image.mimes' => 'L\'image doit être de type: jpeg, png, jpg ou gif.',
        'image.max' => 'L\'image ne doit pas dépasser 10Mo.',
        'number_of_tables.required' => 'Le nombre de tables est requis.',
        'number_of_tables.integer' => 'Le nombre de tables doit être un nombre entier.',
        'number_of_tables.min' => 'Le nombre de tables doit être au moins 1.',
        'seats_per_table.required' => 'Le nombre de places par table est requis.',
        'seats_per_table.integer' => 'Le nombre de places par table doit être un nombre entier.',
        'seats_per_table.min' => 'Le nombre de places par table doit être au moins 1.',
        'seats_per_table.max' => 'Le nombre de places par table ne doit pas dépasser 20.'
    ];
}
}