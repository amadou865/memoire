@extends('layouts.authenticated')

@section('title', 'Statistiques Administrateur')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">📊 Statistiques Globales</h1>
        <p class="text-gray-500 mt-1">Bilan financier et opérationnel</p>
    </div>

    {{-- Evolution CA --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-lg font-bold text-primary mb-6">💰 Évolution du Chiffre d'Affaires (6 derniers mois)</h2>
        @php $maxCa = collect($caParMois)->max('ca') ?: 1; @endphp
        <div class="flex items-end justify-between gap-4 h-64 pt-6">
            @foreach($caParMois as $item)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-accent rounded-t transition-all hover:bg-accent-600"
                         style="height: {{ ($item['ca'] / $maxCa) * 100 }}%; min-height: 8px;">
                    </div>
                    <p class="text-xs font-bold text-primary mt-2">{{ number_format($item['ca'], 0, ',', ' ') }} F</p>
                    <p class="text-xs text-gray-500 uppercase">{{ $item['mois'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Interventions par département --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">🏢 Interventions par Département</h2>
            <div class="space-y-3">
                @foreach($parDept as $d)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-semibold text-primary">{{ $d->departement }}</span>
                        <span class="bg-primary text-white text-xs px-3 py-1 rounded-full font-bold">{{ $d->count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Ratio Utilisateurs --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">👥 Composition des Utilisateurs</h2>
            <div class="space-y-4">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Clients enregistrés</span>
                    <span class="font-bold text-primary">{{ $clientsCount }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Personnel / Staff</span>
                    <span class="font-bold text-accent">{{ $staffCount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection