<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateTablesRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('add_table');
    }

    public function rules()
    {
        return [
            'table_labels' => 'required|array',
            'table_labels.*' => 'required|string|max:50'
        ];
    }
    
    public function messages()
    {
        return [
            'table_labels.required' => 'Au moins un libellé de table est requis.',
            'table_labels.array' => 'Les libellés de table doivent être fournis sous forme de liste.',
            'table_labels.*.required' => 'Chaque libellé de table est requis.',
            'table_labels.*.string' => 'Le libellé de table doit être une chaîne de caractères.',
            'table_labels.*.max' => 'Le libellé de table ne doit pas dépasser 50 caractères.'
        ];
    }
}