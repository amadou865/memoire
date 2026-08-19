@extends('layouts.authenticated')

@section('title', 'Nouveau devis')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.devis.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Créer un devis</h1>
    </div>

    {{-- Si pas d'intervention sélectionnée --}}
    @if(!$intervention)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-lg font-bold text-primary mb-4">Sélectionner une intervention</h2>

            @if($interventionsSansDevis->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">Aucune intervention disponible pour créer un devis</p>
                    <a href="{{ route('receptionniste.interventions.index') }}" class="text-accent font-semibold hover:underline">
                        → Voir les interventions
                    </a>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($interventionsSansDevis as $int)
                        <a href="{{ route('receptionniste.devis.create', ['intervention_id' => $int->id]) }}"
                           class="block border border-gray-200 hover:border-accent rounded-lg p-4 transition-all">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-primary">{{ $int->nature }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        👤 {{ $int->vehicule->client->prenom }} {{ $int->vehicule->client->nom }}
                                        &nbsp;•&nbsp; 🚗 {{ $int->vehicule->marque }} {{ $int->vehicule->modele }}
                                    </p>
                                </div>
                                <x-statut-badge :statut="$int->statut" />
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    @else
        {{-- Formulaire de devis --}}
        @php
            // Calcul auto du montant des pièces
            $montantPiecesAuto = $intervention->lignesPieces->sum(function($lp) {
                return $lp->quantite_utilisee * $lp->prix_unitaire_applique;
            });
            // Calcul auto du coût diagnostic
            $montantValiseAuto = $intervention->diagnostics->sum('cout_valise');
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
             x-data="{
                mo: {{ old('montant_mo', 0) }},
                pieces: {{ old('montant_pieces', $montantPiecesAuto) }},
                valise: {{ old('montant_valise', $montantValiseAuto) }},
                get total() { return parseFloat(this.mo || 0) + parseFloat(this.pieces || 0) + parseFloat(this.valise || 0); },
                format(n) { return new Intl.NumberFormat('fr-FR').format(n); }
             }">

            {{-- Récap intervention --}}
            <div class="bg-primary/5 border border-primary/10 rounded-xl p-4 mb-6">
                <h3 class="font-bold text-primary mb-2">📋 Intervention #{{ $intervention->id }}</h3>
                <p class="text-sm text-gray-700">{{ $intervention->nature }}</p>
                <p class="text-xs text-gray-500 mt-1">
                    👤 {{ $intervention->vehicule->client->prenom }} {{ $intervention->vehicule->client->nom }}
                    &nbsp;•&nbsp; 🚗 {{ $intervention->vehicule->marque }} {{ $intervention->vehicule->modele }} ({{ $intervention->vehicule->immatriculation }})
                </p>
            </div>

            <form action="{{ route('receptionniste.devis.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="intervention_id" value="{{ $intervention->id }}">

                {{-- Détail pièces auto --}}
                @if($intervention->lignesPieces->isNotEmpty())
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">🔩 Pièces consommées (auto)</p>
                        <div class="space-y-1 text-sm">
                            @foreach($intervention->lignesPieces as $lp)
                                <div class="flex justify-between">
                                    <span class="text-gray-700">{{ $lp->piece->designation }} × {{ $lp->quantite_utilisee }}</span>
                                    <span class="font-semibold text-primary">{{ number_format($lp->quantite_utilisee * $lp->prix_unitaire_applique, 0, ',', ' ') }} F</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Formulaire --}}
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Main d'œuvre (F CFA) *</label>
                    <input type="number" name="montant_mo" x-model="mo" min="0" step="500" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    @error('montant_mo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Pièces (F CFA) *</label>
                    <input type="number" name="montant_pieces" x-model="pieces" min="0" step="500" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <p class="text-xs text-gray-500 mt-1">Auto : {{ number_format($montantPiecesAuto, 0, ',', ' ') }} F CFA</p>
                    @error('montant_pieces') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Diagnostic valise (F CFA) *</label>
                    <input type="number" name="montant_valise" x-model="valise" min="0" step="500" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <p class="text-xs text-gray-500 mt-1">Auto : {{ number_format($montantValiseAuto, 0, ',', ' ') }} F CFA</p>
                </div>

                {{-- Total --}}
                <div class="bg-accent/10 border-2 border-accent rounded-xl p-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-primary text-lg">TOTAL</span>
                        <span class="font-bold text-accent text-2xl" x-text="format(total) + ' F CFA'"></span>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('receptionniste.devis.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                    <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">Créer le devis</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection