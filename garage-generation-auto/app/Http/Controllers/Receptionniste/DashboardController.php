<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RendezVous;
use App\Models\Intervention;
use App\Models\Facture;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Statistiques du jour
        $rdvAujourdhui = RendezVous::whereDate('date', $today)
            ->where('statut', '!=', 'annule')
            ->count();

        $interventionsEnCours = Intervention::where('statut', 'en_cours')->count();
        $interventionsTerminees = Intervention::where('statut', 'terminee')
            ->whereDate('date_fin', $today)
            ->count();

        $montantJour = Facture::whereDate('date_emission', $today)
            ->sum('montant_total');

        // RDV à valider (en attente)
        $rdvEnAttente = RendezVous::with('client')
            ->where('statut', 'en_attente')
            ->orderBy('date')
            ->take(5)
            ->get();

        // Planning du jour
        $planningJour = RendezVous::with('client')
            ->whereDate('date', $today)
            ->where('statut', '!=', 'annule')
            ->orderBy('heure')
            ->get();

        // Interventions urgentes
        $interventionsUrgentes = Intervention::with('vehicule.client')
            ->where('priorite', 'urgente')
            ->where('statut', '!=', 'terminee')
            ->take(5)
            ->get();

        // Compteurs globaux
        $totalClients = User::where('role', 'client')->count();
        $totalInterventions = Intervention::count();

        return view('receptionniste.dashboard', compact(
            'rdvAujourdhui',
            'interventionsEnCours',
            'interventionsTerminees',
            'montantJour',
            'rdvEnAttente',
            'planningJour',
            'interventionsUrgentes',
            'totalClients',
            'totalInterventions'
        ));
    }
}