@extends('layouts.authenticated')

@section('title', 'Mes interventions')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Interventions - {{ auth()->user()->departement }}</h1>
        <p class="text-gray-500 mt-1">{{ $interventions->total() }} intervention(s)</p>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex gap-3">
            <select name="statut" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Tous les statuts</option>
                <option value="planifiee" {{ $statut === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                <option value="en_cours" {{ $statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminee" {{ $statut === 'terminee' ? 'selected' : '' }}>Terminée</option>
            </select>
            @if($statut)
                <a href="{{ route('chef.interventions.index') }}" class="text-sm text-gray-500 hover:text-primary self-center">✕ Réinitialiser</a>
            @endif
        </form>
    </div>

    @if($interventions->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucune intervention</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Client / Véhicule</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Nature</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Diagnostics</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Pièces</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Priorité</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($interventions as $int)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $int->date_creation->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-primary text-sm">{{ $int->vehicule->client->prenom }} {{ $int->vehicule->client->nom }}</p>
                                <p class="text-xs text-gray-500">{{ $int->vehicule->marque }} {{ $int->vehicule->modele }} ({{ $int->vehicule->immatriculation }})</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $int->nature }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded font-semibold">{{ $int->diagnostics->count() }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded font-semibold">{{ $int->lignesPieces->count() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $color = match($int->priorite) {
                                        'urgente' => 'bg-red-100 text-red-800',
                                        'haute' => 'bg-orange-100 text-orange-800',
                                        'normale' => 'bg-blue-100 text-blue-800',
                                        'faible' => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="text-xs font-semibold px-2 py-1 rounded {{ $color }}">{{ ucfirst($int->priorite) }}</span>
                            </td>
                            <td class="px-6 py-4"><x-statut-badge :statut="$int->statut" /></td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('chef.interventions.show', $int) }}" class="text-primary hover:text-accent font-semibold text-sm">Traiter</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $interventions->links() }}</div>
    @endif
</div>
@endsection