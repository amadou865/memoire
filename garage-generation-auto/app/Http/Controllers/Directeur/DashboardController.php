<?php

namespace App\Http\Controllers\Directeur;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Essai;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Interventions à contrôler (terminées, sans essai encore fait)
        $aControlerCount = Intervention::where('statut', 'terminee')
            ->whereDoesntHave('essai')
            ->count();

        // Essais du jour
        $essaisJour = Essai::whereDate('date', $today)->count();
        $conformesJour = Essai::whereDate('date', $today)->where('resultat', 'conforme')->count();
        $nonConformesJour = Essai::whereDate('date', $today)->where('resultat', 'non_conforme')->count();

        // Taux de conformité du jour
        $tauxConformite = $essaisJour > 0 ? round(($conformesJour / $essaisJour) * 100, 1) : 0;

        // Charge par département
        $chargeParDepartement = Intervention::whereIn('statut', ['planifiee', 'en_cours'])
            ->selectRaw('departement, count(*) as total')
            ->groupBy('departement')
            ->get();

        // Interventions récentes à contrôler
        $interventionsAControler = Intervention::where('statut', 'terminee')
            ->whereDoesntHave('essai')
            ->with('vehicule.client')
            ->latest('date_fin')
            ->take(10)
            ->get();

        // Retours en atelier (non conformes récents)
        $retoursAtelier = Essai::where('resultat', 'non_conforme')
            ->with('intervention.vehicule.client')
            ->latest()
            ->take(5)
            ->get();

        return view('directeur.dashboard', compact(
            'aControlerCount',
            'essaisJour',
            'conformesJour',
            'nonConformesJour',
            'tauxConformite',
            'chargeParDepartement',
            'interventionsAControler',
            'retoursAtelier'
        ));
    }
}