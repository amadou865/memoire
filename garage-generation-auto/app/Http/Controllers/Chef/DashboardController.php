<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\PieceDetachee;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $departement = auth()->user()->departement;
        $today = Carbon::today();

        // Interventions du département
        $interventionsAujourdhui = Intervention::where('departement', $departement)
            ->whereDate('date_creation', $today)
            ->count();

        $enCours = Intervention::where('departement', $departement)
            ->where('statut', 'en_cours')
            ->count();

        $planifiees = Intervention::where('departement', $departement)
            ->where('statut', 'planifiee')
            ->count();

        $terminees = Intervention::where('departement', $departement)
            ->where('statut', 'terminee')
            ->whereDate('date_fin', $today)
            ->count();

        // Interventions récentes du département
        $interventionsRecentes = Intervention::where('departement', $departement)
            ->whereIn('statut', ['planifiee', 'en_cours'])
            ->with('vehicule.client')
            ->orderBy('priorite', 'desc')
            ->latest()
            ->take(10)
            ->get();

        // Pièces en stock faible
        $stockFaible = PieceDetachee::whereColumn('quantite_stock', '<=', 'seuil_alerte')
            ->take(5)
            ->get();

        return view('chef.dashboard', compact(
            'departement',
            'interventionsAujourdhui',
            'enCours',
            'planifiees',
            'terminees',
            'interventionsRecentes',
            'stockFaible'
        ));
    }
}