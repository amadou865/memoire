<?php

namespace App\Http\Controllers\Directeur;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Essai;
use App\Models\Notification;
use Illuminate\Http\Request;

class ControleQualiteController extends Controller
{
    /**
     * Liste des interventions à contrôler
     */
    public function index(Request $request)
    {
        $filtre = $request->get('filtre', 'a_controler'); // a_controler | conformes | non_conformes | tous

        $query = Intervention::with('vehicule.client', 'essai');

        switch ($filtre) {
            case 'a_controler':
                $query->where('statut', 'terminee')->whereDoesntHave('essai');
                break;
            case 'conformes':
                $query->whereHas('essai', fn($q) => $q->where('resultat', 'conforme'));
                break;
            case 'non_conformes':
                $query->whereHas('essai', fn($q) => $q->where('resultat', 'non_conforme'));
                break;
        }

        $interventions = $query->latest('date_fin')->paginate(15)->withQueryString();

        return view('directeur.controle-qualite.index', compact('interventions', 'filtre'));
    }

    /**
     * Formulaire d'essai pour une intervention
     */
    public function create(Intervention $intervention)
    {
        // Ne peut contrôler que les interventions terminées sans essai
        if ($intervention->statut !== 'terminee') {
            return back()->with('error', 'Cette intervention n\'est pas prête pour le contrôle.');
        }

        if ($intervention->essai) {
            return redirect()->route('directeur.controle-qualite.show', $intervention)
                ->with('info', 'Un essai a déjà été effectué.');
        }

        $intervention->load('vehicule.client', 'diagnostics', 'lignesPieces.piece');

        return view('directeur.controle-qualite.create', compact('intervention'));
    }

    /**
     * Enregistrer l'essai
     */
    public function store(Request $request, Intervention $intervention)
    {
        if ($intervention->essai) {
            return back()->with('error', 'Un essai existe déjà.');
        }

        $data = $request->validate([
            'resultat' => 'required|in:conforme,non_conforme',
            'observations' => 'nullable|string|max:1000',
            'motif_non_conformite' => 'nullable|required_if:resultat,non_conforme|string|max:1000',
        ]);

        $essai = Essai::create([
            'intervention_id' => $intervention->id,
            'date' => now(),
            'resultat' => $data['resultat'],
            'observations' => $data['observations'] ?? null,
            'motif_non_conformite' => $data['motif_non_conformite'] ?? null,
            'heure_validation' => now(),
        ]);

        // Créer une notification
        if ($data['resultat'] === 'conforme') {
            // Notifier réceptionniste : autorisation facturation
            Notification::create([
                'essai_id' => $essai->id,
                'message' => "Intervention #{$intervention->id} conforme. Facturation autorisée.",
                'type_notif' => 'facturation_autorisee',
                'date_envoi' => now(),
                'lu' => false,
            ]);

            return redirect()->route('directeur.controle-qualite.index')
                ->with('success', '✓ Essai conforme ! Facturation autorisée, réceptionniste notifié.');
        } else {
            // Notifier chef de département : retour atelier
            $intervention->update(['statut' => 'en_cours']); // Retour en atelier

            Notification::create([
                'essai_id' => $essai->id,
                'message' => "Intervention #{$intervention->id} non conforme. Retour en atelier. Motif : " . $data['motif_non_conformite'],
                'type_notif' => 'retour_atelier',
                'date_envoi' => now(),
                'lu' => false,
            ]);

            return redirect()->route('directeur.controle-qualite.index')
                ->with('error', '⚠️ Intervention non conforme. Retour en atelier, chef de département notifié.');
        }
    }

    /**
     * Voir l'essai d'une intervention
     */
    public function show(Intervention $intervention)
    {
        if (!$intervention->essai) {
            return redirect()->route('directeur.controle-qualite.create', $intervention);
        }

        $intervention->load('vehicule.client', 'diagnostics', 'lignesPieces.piece', 'essai');

        return view('directeur.controle-qualite.show', compact('intervention'));
    }
}