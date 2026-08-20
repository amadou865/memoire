<?php

namespace App\Http\Controllers\Directeur;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Essai;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Interventions par département (30 derniers jours)
        $interventionsParDepartement = Intervention::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('departement, count(*) as total')
            ->groupBy('departement')
            ->get();

        // Taux de conformité global
        $totalEssais = Essai::count();
        $conformes = Essai::where('resultat', 'conforme')->count();
        $tauxConformiteGlobal = $totalEssais > 0 ? round(($conformes / $totalEssais) * 100, 1) : 0;

        // Retours atelier ce mois
        $retoursMois = Essai::where('resultat', 'non_conforme')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Charge de travail hebdo (7 derniers jours)
        $chargeHebdo = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chargeHebdo[] = [
                'jour' => $date->locale('fr')->translatedFormat('D d/m'),
                'total' => Intervention::whereDate('created_at', $date)->count(),
            ];
        }

        // Interventions par statut
        $parStatut = [
            'planifiee' => Intervention::where('statut', 'planifiee')->count(),
            'en_cours' => Intervention::where('statut', 'en_cours')->count(),
            'terminee' => Intervention::where('statut', 'terminee')->count(),
            'annulee' => Intervention::where('statut', 'annulee')->count(),
        ];

        return view('directeur.statistiques.index', compact(
            'interventionsParDepartement',
            'tauxConformiteGlobal',
            'totalEssais',
            'conformes',
            'retoursMois',
            'chargeHebdo',
            'parStatut'
        ));
    }
}