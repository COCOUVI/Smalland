<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:2048',
             // Validation du champ "level"
            'level' => 'required|in:debutant,intermediaire,expert',

            // Validation du champ "objective"
            'objective' => 'required|string|min:10|max:1000',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix doit être au moins 0.',
            'image.required' => 'L\'image  est obligatoire.',
            'image.image' => "Le fichier doit être une image valide.",
            'image.max' => "L'image ne peut pas dépasser 2MB.",
            'level.required' => 'Le niveau est obligatoire.',
            'level.in' => 'Le niveau doit être soit Débutant, Intermédiaire ou Expert.',
            'objective.required' => 'Les objectifs de la formation sont obligatoires.',
            'objective.min' => 'Les objectifs doivent contenir au moins 10 caractères.',
            'objective.max' => 'Les objectifs ne peuvent pas dépasser 1000 caractères.',
        ];
    }
}
