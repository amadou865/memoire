<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Intervention;
use App\Models\Facture;
use App\Models\PieceDetachee;

class DashboardController extends Controller
{
    public function index()
    {
        // Total interventions du mois
        $interventionsMois = Intervention::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Chiffre d'affaires mensuel (factures payées ce mois)
        $caMensuel = Facture::where('statut', 'paye')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('montant_total');

        // Total utilisateurs actifs
        $totalUsers = User::count();

        // Stock faible
        $stockFaibleCount = PieceDetachee::whereColumn('quantite_stock', '<=', 'seuil_alerte')->count();
        $piecesAlerte = PieceDetachee::whereColumn('quantite_stock', '<=', 'seuil_alerte')->take(5)->get();

        // Dernières interventions
        $interventionsRecentes = Intervention::with('vehicule.client')
            ->latest()
            ->take(5)
            ->get();

        // Répartition utilisateurs par rôle
        $usersParRole = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        return view('admin.dashboard', compact(
            'interventionsMois',
            'caMensuel',
            'totalUsers',
            'stockFaibleCount',
            'piecesAlerte',
            'interventionsRecentes',
            'usersParRole'
        ));
    }
}