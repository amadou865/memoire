<?php

namespace App\Http\Controllers\Directeur;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Essai;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ControleQualiteController extends Controller
{
    /**
     * Liste des interventions avec filtre
     */
    public function index(Request $request): View
    {
        $filtre = $request->get('filtre', 'a_controler');

        $query = Intervention::with(['vehicule.client', 'essai']);

        // Logique de filtrage selon l'onglet cliqué
        if ($filtre === 'a_controler') {
            $interventions = $query->where('statut', 'terminee')
                ->whereDoesntHave('essai')
                ->latest('date_fin')
                ->paginate(10);
        } elseif ($filtre === 'conformes') {
            $interventions = $query->whereHas('essai', function ($q) {
                $q->where('resultat', 'conforme');
            })->latest('date_fin')->paginate(10);
        } elseif ($filtre === 'non_conformes') {
            $interventions = $query->whereHas('essai', function ($q) {
                $q->where('resultat', 'non_conforme');
            })->latest('date_fin')->paginate(10);
        } else {
            // 'tous'
            $interventions = $query->latest('date_fin')->paginate(10);
        }

        // Historique des essais récents
        $essaisRecents = Essai::with(['intervention.vehicule.client'])
            ->latest('date')
            ->take(10)
            ->get();

        return view('directeur.controle-qualite.index', [
            'interventions' => $interventions,
            'interventionsAControler' => $interventions,
            'essaisRecents' => $essaisRecents,
            'filtre' => $filtre,
        ]);
    }

    /**
     * Afficher le détail d'un contrôle
     */
    public function show(Intervention $intervention): View
    {
        $intervention->load(['vehicule.client', 'diagnostics', 'lignesPieces.piece', 'essai']);

        return view('directeur.controle-qualite.show', compact('intervention'));
    }

    /**
     * Formulaire d'essai qualité
     */
    public function create(Intervention $intervention): View
    {
        $intervention->load(['vehicule.client', 'diagnostics', 'lignesPieces.piece']);

        return view('directeur.controle-qualite.create', compact('intervention'));
    }

    /**
     * Enregistrer le résultat du contrôle qualité
     */
    public function store(Request $request, Intervention $intervention): RedirectResponse
    {
        $validated = $request->validate([
            'resultat' => ['required', 'in:conforme,non_conforme'],
            'observations' => ['nullable', 'string', 'max:1000'],
            'motif_non_conformite' => ['required_if:resultat,non_conforme', 'nullable', 'string', 'max:1000'],
        ], [
            'motif_non_conformite.required_if' => 'Le motif est obligatoire en cas de non-conformité.',
        ]);

        // Enregistrer ou mettre à jour l'essai
        $essai = Essai::updateOrCreate(
            ['intervention_id' => $intervention->id],
            [
                'date' => now(),
                'resultat' => $validated['resultat'],
                'observations' => $validated['observations'] ?? null,
                'motif_non_conformite' => $validated['resultat'] === 'non_conforme' ? $validated['motif_non_conformite'] : null,
                'heure_validation' => now(),
            ]
        );

        if ($validated['resultat'] === 'conforme') {
            // 🔔 SI CONFORME : Notifier les Réceptionnistes
            NotificationService::envoyerAuRole(
                'receptionniste',
                'Contrôle qualité conforme ✅',
                "L'intervention #{$intervention->id} pour le véhicule {$intervention->vehicule->immatriculation} est conforme. Facturation autorisée.",
                'qualite_conforme',
                route('receptionniste.interventions.show', $intervention)
            );

            return redirect()->route('directeur.controle-qualite.index')
                ->with('success', '✓ Essai conforme ! Facturation autorisée, réceptionniste notifié.');
        } else {
            // 🔔 SI NON CONFORME : Remettre en cours & Notifier le Chef + Réceptionniste
            $intervention->update([
                'statut' => 'en_cours',
            ]);

            NotificationService::envoyerAuDepartement(
                $intervention->departement,
                'Retour atelier — Non conforme ⚠️',
                "L'intervention #{$intervention->id} ({$intervention->vehicule->immatriculation}) a été refusée au contrôle qualité. Motif : {$validated['motif_non_conformite']}",
                'qualite_non_conforme',
                route('chef.interventions.show', $intervention)
            );

            NotificationService::envoyerAuRole(
                'receptionniste',
                'Intervention non conforme ⚠️',
                "L'intervention #{$intervention->id} a été refusée au contrôle qualité et renvoyée à l'atelier.",
                'qualite_non_conforme',
                route('receptionniste.interventions.show', $intervention)
            );

            return redirect()->route('directeur.controle-qualite.index')
                ->with('error', '✗ Essai non conforme. L\'intervention a été renvoyée à l\'atelier du chef de département.');
        }
    }
}