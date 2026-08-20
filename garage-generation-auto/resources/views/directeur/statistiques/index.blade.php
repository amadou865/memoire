@extends('layouts.authenticated')

@section('title', 'Statistiques')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">📊 Statistiques</h1>
        <p class="text-gray-500 mt-1">Analyse des performances</p>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
            <p class="text-white/80 text-sm">Taux de conformité global</p>
            <p class="text-4xl font-bold mt-2">{{ $tauxConformiteGlobal }}%</p>
            <p class="text-xs text-white/70 mt-1">{{ $conformes }} / {{ $totalEssais }} essais</p>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white">
            <p class="text-white/80 text-sm">Retours atelier ce mois</p>
            <p class="text-4xl font-bold mt-2">{{ $retoursMois }}</p>
            <p class="text-xs text-white/70 mt-1">interventions non conformes</p>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
            <p class="text-white/80 text-sm">Essais réalisés</p>
            <p class="text-4xl font-bold mt-2">{{ $totalEssais }}</p>
            <p class="text-xs text-white/70 mt-1">au total</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Interventions par département --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">🏢 Interventions par département (30 derniers jours)</h2>
            @if($interventionsParDepartement->isEmpty())
                <p class="text-center text-gray-500 py-8">Aucune donnée</p>
            @else
                @php $max = $interventionsParDepartement->max('total'); @endphp
                <div class="space-y-3">
                    @foreach($interventionsParDepartement as $dep)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-semibold text-primary">{{ $dep->departement }}</span>
                                <span class="text-gray-500">{{ $dep->total }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="bg-gradient-to-r from-accent to-orange-500 h-3 rounded-full" style="width: {{ ($dep->total / $max) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Répartition par statut --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">📈 Répartition des interventions</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-semibold text-primary text-sm">Planifiées</span>
                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full font-bold text-sm">{{ $parStatut['planifiee'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <span class="font-semibold text-primary text-sm">En cours</span>
                    <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full font-bold text-sm">{{ $parStatut['en_cours'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                    <span class="font-semibold text-primary text-sm">Terminées</span>
                    <span class="bg-orange-200 text-orange-800 px-3 py-1 rounded-full font-bold text-sm">{{ $parStatut['terminee'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <span class="font-semibold text-primary text-sm">Annulées</span>
                    <span class="bg-red-200 text-red-800 px-3 py-1 rounded-full font-bold text-sm">{{ $parStatut['annulee'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Charge hebdomadaire --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-primary mb-4">📅 Charge de travail (7 derniers jours)</h2>
        @php $maxJour = collect($chargeHebdo)->max('total') ?: 1; @endphp
        <div class="flex items-end justify-between gap-2 h-48">
            @foreach($chargeHebdo as $jour)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-gradient-to-t from-accent to-orange-400 rounded-t"
                         style="height: {{ ($jour['total'] / $maxJour) * 100 }}%; min-height: 4px;">
                        @if($jour['total'] > 0)
                            <p class="text-white text-xs text-center pt-1 font-semibold">{{ $jour['total'] }}</p>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center capitalize">{{ $jour['jour'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection