<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormationRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true; // tu peux gérer avec des politiques si besoin
    }

    /**
     * Règles de validation.
     */
    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            // l’image est optionnelle lors de la MAJ
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Messages personnalisés.
     */
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix doit être au moins 0.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L’image doit être au format jpeg, png, jpg ou gif.',
            'image.max' => 'La taille de l’image ne doit pas dépasser 2 Mo.',
        ];
    }
}
