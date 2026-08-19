<?php

use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════
// ROUTES PUBLIQUES
// ═══════════════════════════════════════════
Route::get('/', function () {
    return view('accueil');
})->name('accueil');

// ═══════════════════════════════════════════
// ROUTES D'AUTHENTIFICATION (Breeze)
// ═══════════════════════════════════════════
require __DIR__.'/auth.php';

// ═══════════════════════════════════════════
// ROUTES PROTÉGÉES (utilisateurs connectés)
// ═══════════════════════════════════════════
Route::middleware(['auth'])->group(function () {

    // ─────────────────────────────────────────
    // Redirection automatique selon le rôle
    // ─────────────────────────────────────────
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdministrateur()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDirecteurTechnique()) {
            return redirect()->route('directeur.dashboard');
        } elseif ($user->isChefDepartement()) {
            return redirect()->route('chef.dashboard');
        } elseif ($user->isReceptionniste()) {
            return redirect()->route('receptionniste.dashboard');
        } elseif ($user->isClient()) {
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('accueil');
    })->name('dashboard');

    // ─────────────────────────────────────────
    // Profil (Breeze)
    // ─────────────────────────────────────────
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─────────────────────────────────────────
    // ESPACE CLIENT
    // ─────────────────────────────────────────
    Route::middleware(['client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');

        // Véhicules
        Route::resource('vehicules', \App\Http\Controllers\Client\VehiculeController::class);

        // Rendez-vous
        Route::resource('rendez-vous', \App\Http\Controllers\Client\RendezVousController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        // Interventions
        Route::get('/interventions', [\App\Http\Controllers\Client\InterventionController::class, 'index'])->name('interventions.index');
        Route::get('/interventions/{intervention}', [\App\Http\Controllers\Client\InterventionController::class, 'show'])->name('interventions.show');

        // Factures
        Route::get('/factures', [\App\Http\Controllers\Client\FactureController::class, 'index'])->name('factures.index');
    });

    // ─────────────────────────────────────────
    // ESPACE RÉCEPTIONNISTE
    // ─────────────────────────────────────────
    Route::middleware(['receptionniste'])->prefix('receptionniste')->name('receptionniste.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Receptionniste\DashboardController::class, 'index'])->name('dashboard');

    // Clients
    Route::resource('clients', \App\Http\Controllers\Receptionniste\ClientController::class);

    // Rendez-vous
    Route::resource('rendez-vous', \App\Http\Controllers\Receptionniste\RendezVousController::class);
    Route::patch('/rendez-vous/{rendezVou}/valider', [\App\Http\Controllers\Receptionniste\RendezVousController::class, 'valider'])->name('rendez-vous.valider');
    Route::patch('/rendez-vous/{rendezVou}/refuser', [\App\Http\Controllers\Receptionniste\RendezVousController::class, 'refuser'])->name('rendez-vous.refuser');

    // Interventions
    Route::resource('interventions', \App\Http\Controllers\Receptionniste\InterventionController::class);
    Route::patch('/interventions/{intervention}/statut', [\App\Http\Controllers\Receptionniste\InterventionController::class, 'changerStatut'])->name('interventions.statut');

    // Devis
    Route::resource('devis', \App\Http\Controllers\Receptionniste\DevisController::class)->parameters(['devis' => 'devi']);
    Route::patch('/devis/{devi}/valider', [\App\Http\Controllers\Receptionniste\DevisController::class, 'valider'])->name('devis.valider');

    // Factures
    Route::get('/factures', [\App\Http\Controllers\Receptionniste\FactureController::class, 'index'])->name('factures.index');
    Route::get('/factures/{facture}', [\App\Http\Controllers\Receptionniste\FactureController::class, 'show'])->name('factures.show');
    Route::delete('/factures/{facture}', [\App\Http\Controllers\Receptionniste\FactureController::class, 'destroy'])->name('factures.destroy');
    Route::post('/devis/{devi}/generer-facture', [\App\Http\Controllers\Receptionniste\FactureController::class, 'genererDepuisDevis'])->name('factures.generer');
    Route::patch('/factures/{facture}/paiement', [\App\Http\Controllers\Receptionniste\FactureController::class, 'enregistrerPaiement'])->name('factures.paiement');
    });
    // ─────────────────────────────────────────
    // ESPACE CHEF DE DÉPARTEMENT
    // ─────────────────────────────────────────
    Route::middleware(['chef'])->prefix('chef')->name('chef.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Chef\DashboardController::class, 'index'])->name('dashboard');

    // Interventions
    Route::get('/interventions', [\App\Http\Controllers\Chef\InterventionController::class, 'index'])->name('interventions.index');
    Route::get('/interventions/{intervention}', [\App\Http\Controllers\Chef\InterventionController::class, 'show'])->name('interventions.show');
    Route::patch('/interventions/{intervention}/statut', [\App\Http\Controllers\Chef\InterventionController::class, 'changerStatut'])->name('interventions.statut');

    // Diagnostics
    Route::get('/interventions/{intervention}/diagnostic', [\App\Http\Controllers\Chef\DiagnosticController::class, 'create'])->name('diagnostics.create');
    Route::post('/interventions/{intervention}/diagnostic', [\App\Http\Controllers\Chef\DiagnosticController::class, 'store'])->name('diagnostics.store');
    Route::delete('/diagnostics/{diagnostic}', [\App\Http\Controllers\Chef\DiagnosticController::class, 'destroy'])->name('diagnostics.destroy');

    // Pièces
    Route::get('/stock', [\App\Http\Controllers\Chef\PieceController::class, 'stock'])->name('stock');
    Route::get('/interventions/{intervention}/pieces/ajouter', [\App\Http\Controllers\Chef\PieceController::class, 'ajouterPiece'])->name('pieces.ajouter');
    Route::post('/interventions/{intervention}/pieces', [\App\Http\Controllers\Chef\PieceController::class, 'storePiece'])->name('pieces.store');
    Route::delete('/lignes-pieces/{lignePiece}', [\App\Http\Controllers\Chef\PieceController::class, 'supprimerPiece'])->name('pieces.destroy');
    });

    // ─────────────────────────────────────────
    // ESPACE DIRECTEUR TECHNIQUE (à venir)
    // ─────────────────────────────────────────
    Route::get('/directeur/dashboard', function () {
        return view('directeur.dashboard');
    })->name('directeur.dashboard');

    // ─────────────────────────────────────────
    // ESPACE ADMINISTRATEUR (à venir)
    // ─────────────────────────────────────────
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});