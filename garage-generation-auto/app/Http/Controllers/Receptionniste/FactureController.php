<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use App\Models\Facture;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FactureController extends Controller
{
    /**
     * Liste des factures avec statistiques et filtre
     */
    public function index(Request $request): View
    {
        $statut = $request->get('statut');

        $query = Facture::with(['devis.intervention.vehicule.client']);

        if ($statut && in_array($statut, ['en_attente', 'paye', 'annule'])) {
            $query->where('statut', $statut);
        }

        $factures = $query->latest('date_emission')->paginate(15);

        // 📊 Statistiques pour les cartes avec les NOMS DE CLÉS EXACTS attendus par la vue
        $stats = [
            'total' => Facture::count(),
            'en_attente' => Facture::where('statut', 'en_attente')->count(),
            'paye' => Facture::where('statut', 'paye')->count(),
            'montant_total' => Facture::where('statut', 'paye')->sum('montant_total'), // 👈 Clé corrigée ici !
        ];

        return view('receptionniste.factures.index', compact('factures', 'stats', 'statut'));
    }

    /**
     * Afficher le détail d'une facture
     */
    public function show(Facture $facture): View
    {
        $facture->load(['devis.intervention.vehicule.client', 'devis.intervention.lignesPieces.piece']);

        return view('receptionniste.factures.show', compact('facture'));
    }

    /**
     * Générer une facture finale depuis un devis validé
     */
    public function genererDepuisDevis(Devis $devi): RedirectResponse
    {
        if ($devi->statut !== 'valide') {
            return back()->with('error', 'Impossible de générer la facture : le devis doit d\'abord être validé par le client.');
        }

        if ($devi->facture) {
            return back()->with('error', 'Une facture existe déjà pour ce devis.');
        }

        $facture = Facture::create([
            'devis_id' => $devi->id,
            'numero' => 'FAC-' . date('Ym') . '-' . sprintf('%04d', Facture::count() + 1),
            'date_emission' => now(),
            'montant_total' => $devi->montant_total,
            'statut' => 'en_attente',
        ]);

        $devi->update(['statut' => 'facture']);

        NotificationService::envoyer(
            $devi->intervention->vehicule->client,
            'Facture disponible 💰',
            "Votre facture n° {$facture->numero} d'un montant de " . number_format($facture->montant_total, 0, ',', ' ') . " FCFA est disponible.",
            'facture_generee',
            route('client.factures.index')
        );

        return redirect()->route('receptionniste.factures.show', $facture)
            ->with('success', 'Facture générée avec succès.');
    }

    /**
     * Enregistrer le paiement d'une facture
     */
    public function enregistrerPaiement(Request $request, Facture $facture): RedirectResponse
    {
        $request->validate([
            'mode_payement' => ['required', 'string', 'max:255'],
        ]);

        $facture->update([
            'statut' => 'paye',
            'mode_payement' => $request->mode_payement,
        ]);

        NotificationService::envoyer(
            $facture->devis->intervention->vehicule->client,
            'Paiement confirmé ✅',
            "Le paiement de votre facture n° {$facture->numero} a bien été enregistré. Merci !",
            'paiement_recu',
            route('client.factures.index')
        );

        return back()->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Supprimer une facture
     */
    public function destroy(Facture $facture): RedirectResponse
    {
        $facture->delete();

        return redirect()->route('receptionniste.factures.index')
            ->with('success', 'Facture supprimée.');
    }
}