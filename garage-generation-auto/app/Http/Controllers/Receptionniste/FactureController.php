<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->get('statut');

        $factures = Facture::with('devis.intervention.vehicule.client')
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Facture::count(),
            'en_attente' => Facture::where('statut', 'en_attente')->count(),
            'paye' => Facture::where('statut', 'paye')->count(),
            'montant_total' => Facture::where('statut', 'paye')->sum('montant_total'),
        ];

        return view('receptionniste.factures.index', compact('factures', 'stats', 'statut'));
    }

    /**
     * Générer une facture depuis un devis
     */
    public function genererDepuisDevis(Devis $devi)
    {
        if ($devi->statut !== 'valide') {
            return back()->with('error', 'Le devis doit être validé avant facturation.');
        }

        if ($devi->facture) {
            return back()->with('error', 'Une facture existe déjà pour ce devis.');
        }

        $facture = Facture::create([
            'devis_id' => $devi->id,
            'numero' => 'FAC-' . date('Y') . '-' . str_pad(Facture::count() + 1, 4, '0', STR_PAD_LEFT),
            'date_emission' => now(),
            'montant_total' => $devi->montant_total,
            'statut' => 'en_attente',
            'mode_payement' => null,
        ]);

        // Mettre à jour le devis
        $devi->update(['statut' => 'facture']);

        return redirect()->route('receptionniste.factures.show', $facture)
            ->with('success', 'Facture générée avec succès !');
    }

    public function show(Facture $facture)
    {
        $facture->load('devis.intervention.vehicule.client', 'devis.intervention.lignesPieces.piece', 'devis.intervention.diagnostics');
        return view('receptionniste.factures.show', compact('facture'));
    }

    /**
     * Enregistrer un paiement
     */
    public function enregistrerPaiement(Request $request, Facture $facture)
    {
        $data = $request->validate([
            'mode_payement' => 'required|in:espèces,carte,virement,chèque,mobile_money',
        ]);

        $facture->update([
            'statut' => 'paye',
            'mode_payement' => $data['mode_payement'],
        ]);

        return back()->with('success', 'Paiement enregistré !');
    }

    public function destroy(Facture $facture)
    {
        if ($facture->statut === 'paye') {
            return back()->with('error', 'Une facture payée ne peut pas être supprimée.');
        }

        // Rétablir le devis
        $facture->devis->update(['statut' => 'valide']);
        $facture->delete();

        return redirect()->route('receptionniste.factures.index')
            ->with('success', 'Facture supprimée.');
    }
}