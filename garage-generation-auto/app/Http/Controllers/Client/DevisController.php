<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DevisController extends Controller
{
    /** Liste des devis du client */
    public function index(): View
    {
        $user = auth()->user();

        $devis = Devis::whereHas('intervention.vehicule', function ($q) use ($user) {
                $q->where('client_id', $user->id);
            })
            ->with(['intervention.vehicule'])
            ->whereIn('statut', ['envoye', 'valide', 'refuse', 'facture'])
            ->latest('date_creation')
            ->paginate(10);

        return view('client.devis.index', compact('devis'));
    }

    /** Détail d'un devis pour validation */
    public function show(Devis $devi): View
    {
        // Sécurité : vérifier que le devis appartient bien au client connecté
        abort_unless($devi->intervention->vehicule->client_id === auth()->id(), 403);

        $devi->load(['intervention.vehicule', 'intervention.lignesPieces.piece', 'intervention.diagnostics']);

        return view('client.devis.show', compact('devi'));
    }

    /** Le client accepte le devis */
    public function valider(Devis $devi): RedirectResponse
    {
        abort_unless($devi->intervention->vehicule->client_id === auth()->id(), 403);

        if ($devi->statut !== 'envoye') {
            return back()->with('error', 'Ce devis a déjà été traité.');
        }

        $devi->update([
            'statut' => 'valide',
            'date_validation' => now(),
        ]);

        // Notification aux réceptionnistes
        NotificationService::envoyerAuRole(
            'receptionniste',
            'Devis accepté par le client ! ✅',
            "Le client " . auth()->user()->prenom . " " . auth()->user()->nom . " a accepté le devis n° {$devi->numero}. Vous pouvez générer la facture.",
            'qualite_conforme',
            route('receptionniste.devis.show', $devi)
        );

        return back()->with('success', 'Merci ! Vous avez accepté le devis. Notre équipe procède à la finalisation.');
    }

    /** Le client refuse le devis */
    public function refuser(Request $request, Devis $devi): RedirectResponse
    {
        abort_unless($devi->intervention->vehicule->client_id === auth()->id(), 403);

        $request->validate([
            'motif_refus' => ['required', 'string', 'max:500'],
        ], [
            'motif_refus.required' => 'Veuillez indiquer la raison du refus.',
        ]);

        if ($devi->statut !== 'envoye') {
            return back()->with('error', 'Ce devis a déjà été traité.');
        }

        $devi->update([
            'statut' => 'refuse',
            'motif_refus' => $request->motif_refus,
            'date_validation' => now(),
        ]);

        // Notification aux réceptionnistes
        NotificationService::envoyerAuRole(
            'receptionniste',
            'Devis refusé par le client ⚠️',
            "Le client " . auth()->user()->prenom . " " . auth()->user()->nom . " a refusé le devis n° {$devi->numero}. Motif : " . $request->motif_refus,
            'qualite_non_conforme',
            route('receptionniste.devis.show', $devi)
        );

        return back()->with('success', 'Votre refus a bien été transmis au garage. Notre équipe prendra contact avec vous.');
    }
}