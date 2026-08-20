@extends('layouts.authenticated')

@section('title', 'Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Direction Technique</h1>
        <p class="text-gray-500 mt-1">Bienvenue {{ auth()->user()->prenom }} • {{ now()->locale('fr')->translatedFormat('l d F Y') }}</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">À contrôler</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $aControlerCount }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Essais du jour</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $essaisJour }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Taux conformité (jour)</p>
                    <p class="text-3xl font-bold text-{{ $tauxConformite >= 80 ? 'green' : ($tauxConformite >= 60 ? 'orange' : 'red') }}-600 mt-1">{{ $tauxConformite }}%</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Non conformes (jour)</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">{{ $nonConformesJour }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Interventions à contrôler --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-primary">🎯 À contrôler</h2>
                <a href="{{ route('directeur.controle-qualite.index') }}" class="text-sm text-accent font-semibold hover:underline">Voir tout →</a>
            </div>

            @if($interventionsAControler->isEmpty())
                <p class="text-center text-gray-500 py-8">🎉 Aucun contrôle en attente !</p>
            @else
                <div class="space-y-3">
                    @foreach($interventionsAControler as $int)
                        <a href="{{ route('directeur.controle-qualite.create', $int) }}" class="block p-4 border border-gray-100 rounded-lg hover:border-accent hover:bg-orange-50/30 transition-all">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-semibold text-primary text-sm">{{ $int->nature }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        🚗 {{ $int->vehicule->marque }} {{ $int->vehicule->modele }} ({{ $int->vehicule->immatriculation }})
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        👤 {{ $int->vehicule->client->prenom }} {{ $int->vehicule->client->nom }}
                                        &nbsp;•&nbsp; 🏢 {{ $int->departement }}
                                    </p>
                                </div>
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded font-semibold whitespace-nowrap">
                                    À tester
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Charge par département --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">📊 Charge par département</h2>
            @if($chargeParDepartement->isEmpty())
                <p class="text-center text-gray-500 py-8 text-sm">Aucune charge</p>
            @else
                @php $maxCharge = $chargeParDepartement->max('total'); @endphp
                <div class="space-y-3">
                    @foreach($chargeParDepartement as $dep)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-semibold text-primary">{{ $dep->departement }}</span>
                                <span class="text-gray-500">{{ $dep->total }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-accent h-2 rounded-full" style="width: {{ ($dep->total / $maxCharge) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Retours atelier récents --}}
    @if($retoursAtelier->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6 mb-8">
            <h2 class="text-lg font-bold text-red-600 mb-4">🚨 Derniers retours en atelier</h2>
            <div class="space-y-2">
                @foreach($retoursAtelier as $essai)
                    <div class="p-3 border-l-4 border-red-400 bg-red-50 rounded">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-semibold text-primary">Intervention #{{ $essai->intervention->id }} - {{ $essai->intervention->nature }}</p>
                                <p class="text-xs text-gray-600 mt-1">📝 {{ $essai->motif_non_conformite }}</p>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ $essai->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Actions rapides --}}
    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('directeur.controle-qualite.index') }}"
           class="bg-accent hover:bg-accent-600 text-white p-4 rounded-xl text-center font-semibold transition-all">
            🎯 Contrôle qualité
        </a>
        <a href="{{ route('directeur.statistiques') }}"
           class="bg-primary hover:bg-primary-light text-white p-4 rounded-xl text-center font-semibold transition-all">
            📊 Statistiques
        </a>
    </div>
</div>
@endsection