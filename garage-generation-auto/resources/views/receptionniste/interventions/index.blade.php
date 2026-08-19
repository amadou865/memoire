@extends('layouts.authenticated')

@section('title', 'Interventions')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Interventions</h1>
            <p class="text-gray-500 mt-1">Suivi de toutes les interventions</p>
        </div>
        <a href="{{ route('receptionniste.interventions.create') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20">
            + Nouvelle intervention
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('receptionniste.interventions.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-primary transition-all">
            <p class="text-gray-500 text-xs uppercase font-semibold">Total</p>
            <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total'] }}</p>
        </a>
        <a href="{{ route('receptionniste.interventions.index', ['statut' => 'planifiee']) }}" class="bg-gray-50 rounded-xl border border-gray-200 p-4 hover:border-gray-400 transition-all">
            <p class="text-gray-700 text-xs uppercase font-semibold">Planifiées</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['planifiee'] }}</p>
        </a>
        <a href="{{ route('receptionniste.interventions.index', ['statut' => 'en_cours']) }}" class="bg-blue-50 rounded-xl border border-blue-200 p-4 hover:border-blue-400 transition-all">
            <p class="text-blue-700 text-xs uppercase font-semibold">En cours</p>
            <p class="text-2xl font-bold text-blue-800 mt-1">{{ $stats['en_cours'] }}</p>
        </a>
        <a href="{{ route('receptionniste.interventions.index', ['statut' => 'terminee']) }}" class="bg-orange-50 rounded-xl border border-orange-200 p-4 hover:border-orange-400 transition-all">
            <p class="text-orange-700 text-xs uppercase font-semibold">Terminées</p>
            <p class="text-2xl font-bold text-orange-800 mt-1">{{ $stats['terminee'] }}</p>
        </a>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Statut</label>
                <select name="statut" onchange="this.form.submit()" class="mt-1 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Tous</option>
                    <option value="planifiee" {{ $statut === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                    <option value="en_cours" {{ $statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="terminee" {{ $statut === 'terminee' ? 'selected' : '' }}>Terminée</option>
                    <option value="annulee" {{ $statut === 'annulee' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Département</label>
                <select name="departement" onchange="this.form.submit()" class="mt-1 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Tous</option>
                    @foreach($departements as $d)
                        <option value="{{ $d }}" {{ $departement === $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Priorité</label>
                <select name="priorite" onchange="this.form.submit()" class="mt-1 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Toutes</option>
                    <option value="faible" {{ $priorite === 'faible' ? 'selected' : '' }}>Faible</option>
                    <option value="normale" {{ $priorite === 'normale' ? 'selected' : '' }}>Normale</option>
                    <option value="haute" {{ $priorite === 'haute' ? 'selected' : '' }}>Haute</option>
                    <option value="urgente" {{ $priorite === 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>
            @if($statut || $departement || $priorite)
                <a href="{{ route('receptionniste.interventions.index') }}" class="text-sm text-gray-500 hover:text-primary">✕ Réinitialiser</a>
            @endif
        </form>
    </div>

    {{-- Liste --}}
    @if($interventions->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucune intervention trouvée</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Client / Véhicule</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Nature</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Département</th>
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
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $int->departement }}</td>
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
                                <a href="{{ route('receptionniste.interventions.show', $int) }}" class="text-primary hover:text-accent font-semibold text-sm">Détails</a>
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