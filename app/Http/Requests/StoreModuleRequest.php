<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ici tu peux mettre une condition (ex: vérifier que l'user est admin)
        // Pour l'instant on autorise tout :
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            // 'formation_id' => 'required|exists:formations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre du module est obligatoire.',
            'titre.string' => 'Le titre doit être une chaîne de caractères.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'formation_id.required' => 'La formation est obligatoire.',
            'formation_id.exists' => 'La formation sélectionnée n’existe pas.',
        ];
    }
}
