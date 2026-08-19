<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use App\Models\Intervention;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->get('statut');

        $devis = Devis::with('intervention.vehicule.client', 'facture')
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Devis::count(),
            'brouillon' => Devis::where('statut', 'brouillon')->count(),
            'valide' => Devis::where('statut', 'valide')->count(),
            'facture' => Devis::where('statut', 'facture')->count(),
        ];

        return view('receptionniste.devis.index', compact('devis', 'stats', 'statut'));
    }

    public function create(Request $request)
    {
        // Doit venir d'une intervention
        $intervention = null;
        if ($request->has('intervention_id')) {
            $intervention = Intervention::with('vehicule.client', 'lignesPieces.piece', 'diagnostics')
                ->find($request->intervention_id);
        }

        // Interventions sans devis, terminées ou en cours
        $interventionsSansDevis = Intervention::whereDoesntHave('devis')
            ->whereIn('statut', ['terminee', 'en_cours'])
            ->with('vehicule.client')
            ->get();

        return view('receptionniste.devis.create', compact('intervention', 'interventionsSansDevis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'intervention_id' => 'required|exists:interventions,id|unique:devis,intervention_id',
            'montant_mo' => 'required|numeric|min:0',
            'montant_pieces' => 'required|numeric|min:0',
            'montant_valise' => 'required|numeric|min:0',
        ]);

        // Génération du numéro
        $data['numero'] = 'DEV-' . date('Y') . '-' . str_pad(Devis::count() + 1, 4, '0', STR_PAD_LEFT);
        $data['date_creation'] = now();
        $data['statut'] = 'brouillon';

        $devis = Devis::create($data);

        return redirect()->route('receptionniste.devis.show', $devis)
            ->with('success', 'Devis créé avec succès !');
    }

    public function show(Devis $devi)
    {
        $devi->load('intervention.vehicule.client', 'intervention.lignesPieces.piece', 'intervention.diagnostics', 'facture');
        return view('receptionniste.devis.show', compact('devi'));
    }

    public function edit(Devis $devi)
    {
        abort_if($devi->statut === 'facture', 403, 'Un devis facturé ne peut plus être modifié.');

        $devi->load('intervention.vehicule.client', 'intervention.lignesPieces.piece');
        return view('receptionniste.devis.edit', compact('devi'));
    }

    public function update(Request $request, Devis $devi)
    {
        abort_if($devi->statut === 'facture', 403);

        $data = $request->validate([
            'montant_mo' => 'required|numeric|min:0',
            'montant_pieces' => 'required|numeric|min:0',
            'montant_valise' => 'required|numeric|min:0',
        ]);

        $devi->update($data);

        return redirect()->route('receptionniste.devis.show', $devi)
            ->with('success', 'Devis mis à jour !');
    }

    public function valider(Devis $devi)
    {
        $devi->update(['statut' => 'valide']);
        return back()->with('success', 'Devis validé !');
    }

    public function destroy(Devis $devi)
    {
        abort_if($devi->statut === 'facture', 403);
        $devi->delete();

        return redirect()->route('receptionniste.devis.index')
            ->with('success', 'Devis supprimé.');
    }
}