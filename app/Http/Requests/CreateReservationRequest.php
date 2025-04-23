<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateReservationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('create_reservation');
    }

    public function rules()
    {
        return [
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'guests' => 'required|integer|min:1|max:20',
            'reservation_date' => 'required|date_format:d/m/Y',
            'reservation_time' => 'required|date_format:H:i',
            'tables' => 'required|array',
            'tables.*' => 'exists:tables,id',
            'meals' => 'nullable|array',
            'meals.*.quantity' => 'nullable|integer|min:0',
            'meals.*.price' => 'nullable|numeric|min:0',
            'special_requests' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'restaurant_id.required' => 'L\'identifiant du restaurant est requis.',
            'restaurant_id.exists' => 'Le restaurant sélectionné n\'existe pas.',
            'name.required' => 'Votre nom est requis.',
            'name.max' => 'Votre nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'Votre adresse e-mail est requise.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
            'email.max' => 'Votre adresse e-mail ne doit pas dépasser 255 caractères.',
            'phone.max' => 'Votre numéro de téléphone ne doit pas dépasser 20 caractères.',
            'guests.required' => 'Le nombre de personnes est requis.',
            'guests.integer' => 'Le nombre de personnes doit être un nombre entier.',
            'guests.min' => 'Le nombre de personnes doit être au moins 1.',
            'guests.max' => 'Le nombre de personnes ne doit pas dépasser 20.',
            'reservation_date.required' => 'La date de réservation est requise.',
            'reservation_date.date_format' => 'Le format de la date doit être JJ/MM/AAAA.',
            'reservation_time.required' => 'L\'heure de réservation est requise.',
            'reservation_time.date_format' => 'Le format de l\'heure doit être HH:MM.',
            'tables.required' => 'Veuillez sélectionner au moins une table.',
            'tables.array' => 'Les tables doivent être fournies sous forme de liste.',
            'tables.*.exists' => 'Une des tables sélectionnées n\'existe pas.',
            'meals.array' => 'Les repas doivent être fournis sous forme de liste.',
            'meals.*.quantity.integer' => 'La quantité doit être un nombre entier.',
            'meals.*.quantity.min' => 'La quantité ne peut pas être négative.',
            'meals.*.price.numeric' => 'Le prix doit être un nombre.',
            'meals.*.price.min' => 'Le prix ne peut pas être négatif.',
            'special_requests.max' => 'Les demandes spéciales ne doivent pas dépasser 500 caractères.',
        ];
    }
}