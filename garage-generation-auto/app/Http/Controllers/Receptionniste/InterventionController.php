<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Vehicule;
use App\Models\User;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InterventionController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->get('statut');
        $departement = $request->get('departement');
        $priorite = $request->get('priorite');

        $interventions = Intervention::with('vehicule.client', 'rendezVous')
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->when($departement, fn($q) => $q->where('departement', $departement))
            ->when($priorite, fn($q) => $q->where('priorite', $priorite))
            ->orderBy('date_creation', 'desc')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Intervention::count(),
            'planifiee' => Intervention::where('statut', 'planifiee')->count(),
            'en_cours' => Intervention::where('statut', 'en_cours')->count(),
            'terminee' => Intervention::where('statut', 'terminee')->count(),
        ];

        $departements = ['Mécanique', 'Électricité', 'Tôlerie', 'Peinture', 'Climatisation'];

        return view('receptionniste.interventions.index', compact(
            'interventions', 'statut', 'departement', 'priorite', 'stats', 'departements'
        ));
    }

    public function create(Request $request)
    {
        // Si vient d'un RDV
        $rendezVous = null;
        if ($request->has('rdv_id')) {
            $rendezVous = RendezVous::with('client.vehicules')->find($request->rdv_id);
        }

        $clients = User::where('role', 'client')->with('vehicules')->get();
        $departements = ['Mécanique', 'Électricité', 'Tôlerie', 'Peinture', 'Climatisation'];

        return view('receptionniste.interventions.create', compact('clients', 'departements', 'rendezVous'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'rendez_vous_id' => 'nullable|exists:rendez_vouses,id',
            'nature' => 'required|string|max:100',
            'departement' => 'required|string|max:50',
            'priorite' => 'required|in:faible,normale,haute,urgente',
            'date_debut' => 'nullable|date',
        ]);

        $data['date_creation'] = now();
        $data['statut'] = 'planifiee';

        Intervention::create($data);

        return redirect()->route('receptionniste.interventions.index')
            ->with('success', 'Intervention créée avec succès !');
    }

    public function show(Intervention $intervention)
    {
        $intervention->load('vehicule.client', 'diagnostics', 'lignesPieces.piece', 'devis.facture', 'essai', 'rendezVous');
        return view('receptionniste.interventions.show', compact('intervention'));
    }

    public function edit(Intervention $intervention)
    {
        $departements = ['Mécanique', 'Électricité', 'Tôlerie', 'Peinture', 'Climatisation'];
        return view('receptionniste.interventions.edit', compact('intervention', 'departements'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $data = $request->validate([
            'nature' => 'required|string|max:100',
            'departement' => 'required|string|max:50',
            'priorite' => 'required|in:faible,normale,haute,urgente',
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
        ]);

        // Auto-remplir date_fin si statut → terminee
        if ($data['statut'] === 'terminee' && empty($data['date_fin'])) {
            $data['date_fin'] = now();
        }

        $intervention->update($data);

        return redirect()->route('receptionniste.interventions.show', $intervention)
            ->with('success', 'Intervention mise à jour !');
    }

    /**
     * Changement rapide de statut
     */
    public function changerStatut(Request $request, Intervention $intervention)
    {
        $request->validate([
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
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

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('receptionniste.interventions.index')
            ->with('success', 'Intervention supprimée.');
    }
}