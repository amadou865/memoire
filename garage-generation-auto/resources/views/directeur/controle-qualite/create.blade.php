@extends('layouts.authenticated')

@section('title', 'Effectuer un essai')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ resultat: 'conforme' }">

    <div class="mb-8">
        <a href="{{ route('directeur.controle-qualite.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Fiche d'essai qualité</h1>
        <p class="text-sm text-gray-500 mt-1">Intervention #{{ $intervention->id }} — {{ $intervention->nature }}</p>
    </div>

    {{-- Résumé intervention --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-bold text-primary mb-4">📋 Résumé intervention</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-xs text-gray-500 uppercase">Client</p>
                <p class="font-semibold text-primary mt-1">{{ $intervention->vehicule->client->prenom }} {{ $intervention->vehicule->client->nom }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Véhicule</p>
                <p class="font-semibold text-primary mt-1">{{ $intervention->vehicule->marque }} {{ $intervention->vehicule->modele }}</p>
                <p class="text-xs text-gray-500 font-mono">{{ $intervention->vehicule->immatriculation }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Département</p>
                <p class="font-semibold text-primary mt-1">{{ $intervention->departement }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Durée</p>
                <p class="font-semibold text-primary mt-1">
                    @if($intervention->date_debut && $intervention->date_fin)
                        {{ $intervention->date_debut->diffForHumans($intervention->date_fin, true) }}
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Diagnostics --}}
    @if($intervention->diagnostics->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-primary mb-4">📋 Diagnostics effectués</h2>
            <div class="space-y-2">
                @foreach($intervention->diagnostics as $diag)
                    <div class="border-l-4 border-primary bg-blue-50 rounded p-3 text-sm">
                        <span class="text-xs font-semibold uppercase text-primary">{{ ucfirst($diag->type) }}</span>
                        <p class="mt-1 text-gray-700">{{ $diag->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Pièces --}}
    @if($intervention->lignesPieces->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-primary mb-4">🔩 Pièces consommées</h2>
            <ul class="space-y-1 text-sm text-gray-700">
                @foreach($intervention->lignesPieces as $lp)
                    <li>• {{ $lp->piece->designation }} × {{ $lp->quantite_utilisee }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire d'essai --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-primary mb-6">✍️ Fiche d'essai</h2>

        <form action="{{ route('directeur.controle-qualite.store', $intervention) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Résultat --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-3">Résultat du test *</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="resultat" value="conforme" x-model="resultat" class="sr-only" checked>
                        <div :class="resultat === 'conforme' ? 'border-green-500 bg-green-50' : 'border-gray-200'"
                             class="border-2 rounded-lg p-4 text-center transition-all">
                            <div class="text-3xl mb-1">✓</div>
                            <p class="font-bold text-green-600">CONFORME</p>
                            <p class="text-xs text-gray-500 mt-1">Facturation autorisée</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="resultat" value="non_conforme" x-model="resultat" class="sr-only">
                        <div :class="resultat === 'non_conforme' ? 'border-red-500 bg-red-50' : 'border-gray-200'"
                             class="border-2 rounded-lg p-4 text-center transition-all">
                            <div class="text-3xl mb-1">✕</div>
                            <p class="font-bold text-red-600">NON CONFORME</p>
                            <p class="text-xs text-gray-500 mt-1">Retour en atelier</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Observations --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Observations</label>
                <textarea name="observations" rows="3" placeholder="Points contrôlés, remarques..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">{{ old('observations') }}</textarea>
                @error('observations') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Motif non conformité (uniquement si non conforme) --}}
            <div x-show="resultat === 'non_conforme'" x-transition>
                <label class="block text-sm font-semibold text-red-600 mb-2">Motif de non-conformité *</label>
                <textarea name="motif_non_conformite" rows="3" placeholder="Décrivez précisément le problème pour le chef de département..."
                          class="w-full px-4 py-3 border border-red-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">{{ old('motif_non_conformite') }}</textarea>
                <p class="text-xs text-red-600 mt-1">⚠️ Le chef de département sera notifié pour reprendre l'intervention</p>
                @error('motif_non_conformite') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Info horodatage --}}
            <div class="bg-gray-50 border border-gray-100 rounded-lg p-3 text-xs text-gray-500 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Horodatage automatique : {{ now()->format('d/m/Y à H:i') }} par {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
            </div>

            {{-- Boutons --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('directeur.controle-qualite.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit"
                        :class="resultat === 'conforme' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'"
                        class="text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg">
                    <span x-show="resultat === 'conforme'">✓ Valider (Autoriser facturation)</span>
                    <span x-show="resultat === 'non_conforme'">✕ Renvoyer en atelier</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection