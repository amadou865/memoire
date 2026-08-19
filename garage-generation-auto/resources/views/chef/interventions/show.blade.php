@extends('layouts.authenticated')

@section('title', 'Intervention #' . $intervention->id)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('chef.interventions.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <div class="flex justify-between items-start mt-2">
            <div>
                <h1 class="text-3xl font-bold text-primary">Intervention #{{ $intervention->id }}</h1>
                <p class="text-gray-500 mt-1">{{ $intervention->nature }}</p>
            </div>
            <x-statut-badge :statut="$intervention->statut" />
        </div>
    </div>

    {{-- Changer le statut --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-bold text-primary mb-4">🔄 Changer le statut</h2>
        <form action="{{ route('chef.interventions.statut', $intervention) }}" method="POST" class="flex gap-3">
            @csrf @method('PATCH')
            <select name="statut" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg">
                <option value="planifiee" {{ $intervention->statut === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                <option value="en_cours" {{ $intervention->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminee" {{ $intervention->statut === 'terminee' ? 'selected' : '' }}>Terminée (prête pour contrôle)</option>
            </select>
            <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2 rounded-lg text-sm">Mettre à jour</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Info intervention --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">🔧 Informations</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Créée le</span>
                    <span class="font-semibold text-primary">{{ $intervention->date_creation->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Date début</span>
                    <span class="font-semibold text-primary">{{ $intervention->date_debut?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Date fin</span>
                    <span class="font-semibold text-primary">{{ $intervention->date_fin?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Priorité</span>
                    <span class="font-semibold text-primary">{{ ucfirst($intervention->priorite) }}</span>
                </div>
            </div>
        </div>

        {{-- Véhicule + client --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">🚗 Véhicule & Client</h2>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="font-bold text-primary">{{ $intervention->vehicule->marque }} {{ $intervention->vehicule->modele }}</p>
                    <p class="text-xs text-gray-500 font-mono">{{ $intervention->vehicule->immatriculation }}</p>
                    <p class="text-xs text-gray-500">Année {{ $intervention->vehicule->annee }} • {{ number_format($intervention->vehicule->kilometrage, 0, ',', ' ') }} km</p>
                </div>
                <div class="border-t border-gray-100 pt-3">
                    <p class="font-semibold text-primary">{{ $intervention->vehicule->client->prenom }} {{ $intervention->vehicule->client->nom }}</p>
                    <p class="text-xs text-gray-500">📞 {{ $intervention->vehicule->client->telephone }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Diagnostics --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-primary">📋 Diagnostics ({{ $intervention->diagnostics->count() }})</h2>
            <a href="{{ route('chef.diagnostics.create', $intervention) }}" class="bg-accent hover:bg-accent-600 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                + Nouveau diagnostic
            </a>
        </div>

        @if($intervention->diagnostics->isEmpty())
            <p class="text-center text-gray-500 py-8 text-sm">Aucun diagnostic enregistré</p>
        @else
            <div class="space-y-3">
                @foreach($intervention->diagnostics as $diag)
                    <div class="border-l-4 border-primary bg-blue-50 rounded p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    @if($diag->type === 'visuel')
                                        <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded font-semibold">👁️ VISUEL</span>
                                    @else
                                        <span class="bg-purple-500 text-white text-xs px-2 py-0.5 rounded font-semibold">🔌 VALISE</span>
                                    @endif
                                    <span class="text-xs text-gray-500">{{ $diag->date->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="text-sm text-primary font-semibold">{{ $diag->description }}</p>
                                @if($diag->codes_defauts)
                                    <p class="text-xs text-gray-700 mt-1">🔍 Codes : <span class="font-mono">{{ $diag->codes_defauts }}</span></p>
                                @endif
                                @if($diag->observations)
                                    <p class="text-xs text-gray-600 mt-1">📝 {{ $diag->observations }}</p>
                                @endif
                                @if($diag->cout_valise > 0)
                                    <p class="text-xs text-purple-700 font-semibold mt-1">💰 Coût valise : {{ number_format($diag->cout_valise, 0, ',', ' ') }} F CFA</p>
                                @endif
                            </div>
                            <form action="{{ route('chef.diagnostics.destroy', $diag) }}" method="POST" onsubmit="return confirm('Supprimer ce diagnostic ?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xs">🗑️</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Pièces consommées --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-primary">🔩 Pièces consommées ({{ $intervention->lignesPieces->count() }})</h2>
            <a href="{{ route('chef.pieces.ajouter', $intervention) }}" class="bg-accent hover:bg-accent-600 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                + Ajouter une pièce
            </a>
        </div>

        @if($intervention->lignesPieces->isEmpty())
            <p class="text-center text-gray-500 py-8 text-sm">Aucune pièce consommée</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Référence</th>
                        <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Désignation</th>
                        <th class="text-center py-2 text-xs font-semibold text-gray-500 uppercase">Qté</th>
                        <th class="text-right py-2 text-xs font-semibold text-gray-500 uppercase">PU</th>
                        <th class="text-right py-2 text-xs font-semibold text-gray-500 uppercase">Total</th>
                        <th class="text-right py-2 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $totalPieces = 0; @endphp
                    @foreach($intervention->lignesPieces as $lp)
                        @php
                            $sousTotal = $lp->quantite_utilisee * $lp->prix_unitaire_applique;
                            $totalPieces += $sousTotal;
                        @endphp
                        <tr>
                            <td class="py-2 font-mono text-xs text-gray-500">{{ $lp->piece->reference }}</td>
                            <td class="py-2">{{ $lp->piece->designation }}</td>
                            <td class="py-2 text-center">{{ $lp->quantite_utilisee }}</td>
                            <td class="py-2 text-right">{{ number_format($lp->prix_unitaire_applique, 0, ',', ' ') }} F</td>
                            <td class="py-2 text-right font-semibold">{{ number_format($sousTotal, 0, ',', ' ') }} F</td>
                            <td class="py-2 text-right">
                                <form action="{{ route('chef.pieces.destroy', $lp) }}" method="POST" onsubmit="return confirm('Retirer cette pièce ? Le stock sera restauré.')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 text-xs">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-200">
                        <td colspan="4" class="pt-3 font-bold text-primary text-right">TOTAL PIÈCES :</td>
                        <td class="pt-3 text-right font-bold text-accent">{{ number_format($totalPieces, 0, ',', ' ') }} F CFA</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>
@endsection