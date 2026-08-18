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

    // Redirection automatique selon le rôle
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

    // Dashboards par rôle
    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::get('/receptionniste/dashboard', function () {
        return view('receptionniste.dashboard');
    })->name('receptionniste.dashboard');

    Route::get('/chef/dashboard', function () {
        return view('chef.dashboard');
    })->name('chef.dashboard');

    Route::get('/directeur/dashboard', function () {
        return view('directeur.dashboard');
    })->name('directeur.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Routes Breeze (profil)
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});