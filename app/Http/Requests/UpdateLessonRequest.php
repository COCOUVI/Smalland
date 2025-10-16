<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'titre' => 'required|string|max:255',
            'video_url' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400', // 100MB max
            'pdf_url' => 'nullable|file|mimes:pdf|max:51200', // 50MB max   // Gardez si vous voulez aussi accepter des URLs
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            'video_url.mimes' => 'Le fichier vidéo doit être de type: mp4, avi, mov, wmv',
            'video_url.max' => 'La vidéo ne doit pas dépasser 100MB',
            'pdf_url.mimes' => 'Le fichier PDF doit être au format PDF',
            'pdf_url.max' => 'Le PDF ne doit pas dépasser 50MB',
        ];
    }
}