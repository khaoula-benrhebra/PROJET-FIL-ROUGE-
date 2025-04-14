<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateCategoryRequest extends FormRequest
{

    public function authorize()
    {
        return Gate::allows('update_categories');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->route('id'),
            'description' => 'nullable|string'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Le nom de la catégorie est requis.',
            'name.unique' => 'Une catégorie avec ce nom existe déjà.',
            'name.max' => 'Le nom de la catégorie ne doit pas dépasser 255 caractères.'
        ];
    }
}