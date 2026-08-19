@extends('layouts.authenticated')

@section('title', 'Détail intervention')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.interventions.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <div class="flex justify-between items-start mt-2">
            <div>
                <h1 class="text-3xl font-bold text-primary">Intervention #{{ $intervention->id }}</h1>
                <p class="text-gray-500 mt-1">{{ $intervention->nature }}</p>
            </div>
            <div class="flex gap-2">
                <x-statut-badge :statut="$intervention->statut" />
                @php
                    $color = match($intervention->priorite) {
                        'urgente' => 'bg-red-100 text-red-800',
                        'haute' => 'bg-orange-100 text-orange-800',
                        'normale' => 'bg-blue-100 text-blue-800',
                        'faible' => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                    {{ ucfirst($intervention->priorite) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Changement de statut rapide --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-bold text-primary mb-4">🔄 Changer le statut</h2>
        <form action="{{ route('receptionniste.interventions.statut', $intervention) }}" method="POST" class="flex gap-3">
            @csrf @method('PATCH')
            <select name="statut" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg">
                <option value="planifiee" {{ $intervention->statut === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                <option value="en_cours" {{ $intervention->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminee" {{ $intervention->statut === 'terminee' ? 'selected' : '' }}>Terminée</option>
                <option value="annulee" {{ $intervention->statut === 'annulee' ? 'selected' : '' }}>Annulée</option>
            </select>
            <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2 rounded-lg text-sm">Mettre à jour</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Info intervention --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">🔧 Détails</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Créée le</span>
                    <span class="font-semibold text-primary">{{ $intervention->date_creation->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Département</span>
                    <span class="font-semibold text-primary">{{ $intervention->departement }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Date début</span>
                    <span class="font-semibold text-primary">{{ $intervention->date_debut ? $intervention->date_debut->format('d/m/Y H:i') : '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date fin</span>
                    <span class="font-semibold text-primary">{{ $intervention->date_fin ? $intervention->date_fin->format('d/m/Y H:i') : '—' }}</span>
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
                </div>
                <div class="border-t border-gray-100 pt-3">
                    <p class="font-semibold text-primary">{{ $intervention->vehicule->client->prenom }} {{ $intervention->vehicule->client->nom }}</p>
                    <p class="text-xs text-gray-500">📞 {{ $intervention->vehicule->client->telephone }}</p>
                    <p class="text-xs text-gray-500">📧 {{ $intervention->vehicule->client->email }}</p>
                </div>
                <a href="{{ route('receptionniste.clients.show', $intervention->vehicule->client) }}" class="block text-center bg-primary/10 hover:bg-primary/20 text-primary font-semibold py-2 rounded-lg text-sm">
                    Fiche client complète
                </a>
            </div>
        </div>
    </div>

    {{-- Diagnostics --}}
    @if($intervention->diagnostics->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-primary mb-4">📋 Diagnostics ({{ $intervention->diagnostics->count() }})</h2>
            <div class="space-y-3">
                @foreach($intervention->diagnostics as $diag)
                    <div class="border-l-4 border-primary bg-blue-50 rounded p-4">
                        <div class="flex justify-between">
                            <span class="text-xs font-semibold uppercase text-primary">{{ ucfirst($diag->type) }}</span>
                            <span class="text-xs text-gray-500">{{ $diag->date->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-700 mt-2">{{ $diag->description }}</p>
                        @if($diag->observations)
                            <p class="text-xs text-gray-500 mt-1">📝 {{ $diag->observations }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Pièces --}}
    @if($intervention->lignesPieces->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-primary mb-4">🔩 Pièces consommées</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Pièce</th>
                        <th class="text-center py-2 text-xs font-semibold text-gray-500 uppercase">Qté</th>
                        <th class="text-right py-2 text-xs font-semibold text-gray-500 uppercase">PU</th>
                        <th class="text-right py-2 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($intervention->lignesPieces as $lp)
                        <tr>
                            <td class="py-2">{{ $lp->piece->designation }}</td>
                            <td class="py-2 text-center">{{ $lp->quantite_utilisee }}</td>
                            <td class="py-2 text-right">{{ number_format($lp->prix_unitaire_applique, 0, ',', ' ') }} F</td>
                            <td class="py-2 text-right font-semibold">{{ number_format($lp->quantite_utilisee * $lp->prix_unitaire_applique, 0, ',', ' ') }} F</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Actions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-primary mb-4">⚡ Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('receptionniste.interventions.edit', $intervention) }}" class="bg-primary hover:bg-primary-light text-white font-semibold px-4 py-2 rounded-lg text-sm">
                ✏️ Modifier
            </a>
            <form action="{{ route('receptionniste.interventions.destroy', $intervention) }}" method="POST" onsubmit="return confirm('Supprimer cette intervention ?')" class="inline">
                @csrf @method('DELETE')
                <button class="border border-red-200 text-red-500 hover:bg-red-50 font-semibold px-4 py-2 rounded-lg text-sm">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection