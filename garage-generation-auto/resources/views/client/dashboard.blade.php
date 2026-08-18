@extends('layouts.authenticated')

@section('title', 'Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- En-tête --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Bonjour, {{ auth()->user()->prenom }} 👋</h1>
        <p class="text-gray-500 mt-1">Voici un aperçu de votre activité</p>
    </div>

    {{-- Cartes statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Mes véhicules</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $nbVehicules }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">RDV en cours</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $nbRdvEnCours }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Interventions</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $nbInterventions }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Dernière facture</p>
                    <p class="text-2xl font-bold text-primary mt-1">
                        {{ $derniereFacture ? number_format($derniereFacture->montant_total, 0, ',', ' ') . ' F' : '—' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Prochain RDV --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">Prochain rendez-vous</h2>
            @if($prochainRdv)
                <div class="border-l-4 border-accent bg-orange-50 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-primary">{{ $prochainRdv->type_intervention }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                📅 {{ \Carbon\Carbon::parse($prochainRdv->date)->locale('fr')->translatedFormat('d F Y') }}
                                à {{ \Carbon\Carbon::parse($prochainRdv->heure)->format('H\hi') }}
                            </p>
                        </div>
                        <x-statut-badge :statut="$prochainRdv->statut" />
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">Aucun rendez-vous prévu</p>
                    <a href="{{ route('client.rendez-vous.create') }}"
                       class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg transition-all">
                        + Prendre un rendez-vous
                    </a>
                </div>
            @endif
        </div>

        {{-- Dernière intervention --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">Dernière intervention</h2>
            @if($derniereIntervention)
                <div class="border-l-4 border-primary bg-blue-50 rounded-lg p-4">
                    <p class="font-semibold text-primary">{{ $derniereIntervention->nature }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        🚗 {{ $derniereIntervention->vehicule->marque }} {{ $derniereIntervention->vehicule->modele }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        📅 {{ $derniereIntervention->date_creation->locale('fr')->translatedFormat('d F Y') }}
                    </p>
                    <div class="mt-2">
                        <x-statut-badge :statut="$derniereIntervention->statut" />
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Aucune intervention pour le moment</p>
            @endif
        </div>
    </div>

    {{-- Boutons d'action --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('client.rendez-vous.create') }}"
           class="bg-accent hover:bg-accent-600 text-white p-4 rounded-xl text-center font-semibold transition-all">
            📅 Nouveau RDV
        </a>
        <a href="{{ route('client.vehicules.create') }}"
           class="bg-primary hover:bg-primary-light text-white p-4 rounded-xl text-center font-semibold transition-all">
            🚗 Ajouter véhicule
        </a>
        <a href="{{ route('client.interventions.index') }}"
           class="bg-white border-2 border-gray-200 hover:border-primary text-primary p-4 rounded-xl text-center font-semibold transition-all">
            🔧 Interventions
        </a>
        <a href="{{ route('client.factures.index') }}"
           class="bg-white border-2 border-gray-200 hover:border-primary text-primary p-4 rounded-xl text-center font-semibold transition-all">
            📄 Factures
        </a>
    </div>
</div>
@endsection