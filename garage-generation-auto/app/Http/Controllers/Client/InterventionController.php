<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Intervention;

class InterventionController extends Controller
{
    public function index()
    {
        $vehiculeIds = auth()->user()->vehicules()->pluck('id');

        $interventions = Intervention::whereIn('vehicule_id', $vehiculeIds)
            ->with('vehicule')
            ->latest()
            ->paginate(10);

        return view('client.interventions.index', compact('interventions'));
    }

    public function show(Intervention $intervention)
    {
        // Vérifier que l'intervention appartient bien à un véhicule du client
        $vehiculeIds = auth()->user()->vehicules()->pluck('id')->toArray();
        abort_unless(in_array($intervention->vehicule_id, $vehiculeIds), 403);

        $intervention->load('vehicule', 'diagnostics', 'lignesPieces.piece', 'devis');

        return view('client.interventions.show', compact('intervention'));
    }
}