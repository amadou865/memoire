<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Facture;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Stats du client
        $nbVehicules = $user->vehicules()->count();
        $nbRdvEnCours = $user->rendezVousClient()
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->count();

        // Récupérer les IDs des véhicules du client
        $vehiculeIds = $user->vehicules()->pluck('id');

        $nbInterventions = Intervention::whereIn('vehicule_id', $vehiculeIds)->count();

        $derniereIntervention = Intervention::whereIn('vehicule_id', $vehiculeIds)
            ->with('vehicule')
            ->latest()
            ->first();

        // Dernière facture
        $derniereFacture = Facture::whereHas('devis.intervention', function ($q) use ($vehiculeIds) {
            $q->whereIn('vehicule_id', $vehiculeIds);
        })->latest()->first();

        // Prochains RDV
        $prochainRdv = $user->rendezVousClient()
            ->where('date', '>=', now())
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->orderBy('date')
            ->first();

        return view('client.dashboard', compact(
            'nbVehicules',
            'nbRdvEnCours',
            'nbInterventions',
            'derniereIntervention',
            'derniereFacture',
            'prochainRdv'
        ));
    }
}