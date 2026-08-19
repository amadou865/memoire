<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function index(Request $request)
    {
        $departement = auth()->user()->departement;
        $statut = $request->get('statut');

        $interventions = Intervention::where('departement', $departement)
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->with('vehicule.client', 'diagnostics', 'lignesPieces')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('chef.interventions.index', compact('interventions', 'statut'));
    }

    public function show(Intervention $intervention)
    {
        // Vérifier que l'intervention est bien du département du chef
        abort_if($intervention->departement !== auth()->user()->departement, 403);

        $intervention->load('vehicule.client', 'diagnostics', 'lignesPieces.piece', 'devis', 'essai');

        return view('chef.interventions.show', compact('intervention'));
    }

    public function changerStatut(Request $request, Intervention $intervention)
    {
        abort_if($intervention->departement !== auth()->user()->departement, 403);

        $request->validate([
            'statut' => 'required|in:planifiee,en_cours,terminee',
        ]);

        $data = ['statut' => $request->statut];

        if ($request->statut === 'en_cours' && !$intervention->date_debut) {
            $data['date_debut'] = now();
        }

        if ($request->statut === 'terminee') {
            $data['date_fin'] = now();
        }

        $intervention->update($data);

        return back()->with('success', 'Statut mis à jour !');
    }
}