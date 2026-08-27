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
     * Liste des factures
     */
    public function index(): View
    {
        $factures = Facture::with(['devis.intervention.vehicule.client'])
            ->latest('date_emission')
            ->paginate(15);

        return view('receptionniste.factures.index', compact('factures'));
    }

    /**
     * Afficher une facture
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
        // 🛡️ SÉCURITÉ : Bloquer si le devis n'est pas encore validé par le client !
        if ($devi->statut !== 'valide') {
            return back()->with('error', 'Impossible de générer la facture : le devis doit d\'abord être validé par le client.');
        }

        // Si déjà facturé
        if ($devi->facture) {
            return back()->with('error', 'Une facture existe déjà pour ce devis.');
        }

        // Création de la facture
        $facture = Facture::create([
            'devis_id' => $devi->id,
            'numero' => 'FAC-' . date('Ym') . '-' . sprintf('%04d', Facture::count() + 1),
            'date_emission' => now(),
            'montant_total' => $devi->montant_total,
            'statut' => 'en_attente',
        ]);

        // Mise à jour du devis
        $devi->update(['statut' => 'facture']);

        // Notifier le client
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
     * Enregistrer le paiement de la facture
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

        // Notifier le client
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