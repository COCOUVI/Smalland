<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\user_formation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class AttestationController extends Controller
{
    public function download($id)
    {
        $user = Auth::user();
        $formation = Formation::findOrFail($id);

        $userFormation = user_formation::where('user_id', $user->id)
            ->where('formation_id', $id)
            ->first();

        if (!$userFormation || $userFormation->progression < 100) {
            abort(403, 'Certificat non disponible. Formation non terminée.');
        }

        // Créer le dossier si inexistant
        $directory = public_path('attestations');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Chemin du fichier PDF
        $fileName = "attestation_{$formation->id}_{$user->id}.pdf";
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;

        // Créer le PDF et l'enregistrer
        $pdf = Pdf::loadView('attestation.pdf', [
            'user' => $user,
            'formation' => $formation,
            'date' => now()->format('d/m/Y'),
        ]);
        $pdf->save($filePath);

        // Mettre à jour path_attestation si c'est null
        if (is_null($userFormation->path_attestation)) {
            $userFormation->path_attestation = "attestations/{$fileName}";
            $userFormation->save();
        }

        return response()->download($filePath);
    }
}
