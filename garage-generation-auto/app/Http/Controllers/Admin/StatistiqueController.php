<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Facture;
use App\Models\User;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Chiffre d'affaires par mois (6 derniers mois)
        $caParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $caParMois[] = [
                'mois' => $date->locale('fr')->translatedFormat('M Y'),
                'ca' => Facture::where('statut', 'paye')
                    ->whereMonth('updated_at', $date->month)
                    ->whereYear('updated_at', $date->year)
                    ->sum('montant_total'),
            ];
        }

        // Interventions par département
        $parDept = Intervention::selectRaw('departement, count(*) as count')
            ->groupBy('departement')
            ->get();

        // Répartition par rôle utilisateur
        $clientsCount = User::where('role', 'client')->count();
        $staffCount = User::where('role', '!=', 'client')->count();

        // Factures globales
        $facturesTotal = Facture::sum('montant_total');
        $facturesPayees = Facture::where('statut', 'paye')->sum('montant_total');

        return view('admin.statistiques.index', compact(
            'caParMois',
            'parDept',
            'clientsCount',
            'staffCount',
            'facturesTotal',
            'facturesPayees'
        ));
    }
}