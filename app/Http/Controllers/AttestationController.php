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

        $pdf = Pdf::loadView('attestation.pdf', [
            'user' => $user,
            'formation' => $formation,
            'date' => now()->format('d/m/Y'),
        ]);

        return $pdf->download("attestation_{$formation->id}_{$user->id}.pdf");
    }
}
