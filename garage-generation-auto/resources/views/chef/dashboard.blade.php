@extends('layouts.authenticated')

@section('title', 'Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Département {{ $departement }}</h1>
        <p class="text-gray-500 mt-1">Bienvenue {{ auth()->user()->prenom }} • {{ now()->locale('fr')->translatedFormat('l d F Y') }}</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Aujourd'hui</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $interventionsAujourdhui }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Planifiées</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $planifiees }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">En cours</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $enCours }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Terminées aujourd'hui</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $terminees }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Interventions à traiter --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-primary">🔧 Interventions à traiter</h2>
                <a href="{{ route('chef.interventions.index') }}" class="text-sm text-accent font-semibold hover:underline">Voir tout →</a>
            </div>

            @if($interventionsRecentes->isEmpty())
                <p class="text-center text-gray-500 py-8">Aucune intervention en attente</p>
            @else
                <div class="space-y-3">
                    @foreach($interventionsRecentes as $int)
                        <a href="{{ route('chef.interventions.show', $int) }}" class="block p-4 border border-gray-100 rounded-lg hover:border-accent hover:bg-orange-50/30 transition-all">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-semibold text-primary text-sm">{{ $int->nature }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        🚗 {{ $int->vehicule->marque }} {{ $int->vehicule->modele }} ({{ $int->vehicule->immatriculation }})
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        👤 {{ $int->vehicule->client->prenom }} {{ $int->vehicule->client->nom }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    @php
                                        $color = match($int->priorite) {
                                            'urgente' => 'bg-red-100 text-red-800',
                                            'haute' => 'bg-orange-100 text-orange-800',
                                            'normale' => 'bg-blue-100 text-blue-800',
                                            'faible' => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $color }}">{{ ucfirst($int->priorite) }}</span>
                                    <x-statut-badge :statut="$int->statut" />
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Stock faible --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-primary">⚠️ Stock faible</h2>
                <a href="{{ route('chef.stock') }}" class="text-sm text-accent font-semibold hover:underline">Voir tout →</a>
            </div>

            @if($stockFaible->isEmpty())
                <p class="text-center text-gray-500 py-8 text-sm">Stock OK ✓</p>
            @else
                <div class="space-y-2">
                    @foreach($stockFaible as $piece)
                        <div class="p-3 border-l-4 border-red-400 bg-red-50 rounded">
                            <p class="text-sm font-semibold text-primary">{{ $piece->designation }}</p>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500">{{ $piece->reference }}</span>
                                <span class="text-xs font-bold text-red-600">
                                    {{ $piece->quantite_stock }} / {{ $piece->seuil_alerte }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('chef.interventions.index') }}"
           class="bg-accent hover:bg-accent-600 text-white p-4 rounded-xl text-center font-semibold transition-all">
            🔧 Mes interventions
        </a>
        <a href="{{ route('chef.stock') }}"
           class="bg-primary hover:bg-primary-light text-white p-4 rounded-xl text-center font-semibold transition-all">
            📦 Consulter le stock
        </a>
    </div>
</div>
@endsection