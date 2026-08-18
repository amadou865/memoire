@extends('layouts.authenticated')

@section('title', 'Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Bonjour, {{ auth()->user()->prenom }} 👋</h1>
        <p class="text-gray-500 mt-1">{{ now()->locale('fr')->translatedFormat('l d F Y') }}</p>
    </div>

    {{-- Statistiques du jour --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">RDV du jour</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $rdvAujourdhui }}</p>
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
                    <p class="text-gray-500 text-sm">Interventions en cours</p>
                    <p class="text-3xl font-bold text-primary mt-1">{{ $interventionsEnCours }}</p>
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
                    <p class="text-3xl font-bold text-primary mt-1">{{ $interventionsTerminees }}</p>
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
                    <p class="text-gray-500 text-sm">Facturé aujourd'hui</p>
                    <p class="text-2xl font-bold text-primary mt-1">{{ number_format($montantJour, 0, ',', ' ') }} F</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Planning du jour --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-primary">📅 Planning du jour</h2>
                <span class="text-sm text-gray-500">{{ $planningJour->count() }} RDV</span>
            </div>

            @if($planningJour->isEmpty())
                <p class="text-center text-gray-500 py-8">Aucun rendez-vous aujourd'hui</p>
            @else
                <div class="space-y-3">
                    @foreach($planningJour as $rdv)
                        <div class="flex items-center gap-4 p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-16 text-center">
                                <p class="text-2xl font-bold text-accent">{{ \Carbon\Carbon::parse($rdv->heure)->format('H\hi') }}</p>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-primary">{{ $rdv->client->prenom }} {{ $rdv->client->nom }}</p>
                                <p class="text-sm text-gray-500">{{ $rdv->type_intervention }}</p>
                            </div>
                            <x-statut-badge :statut="$rdv->statut" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- RDV en attente de validation --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-primary">⏳ À valider</h2>
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-semibold">{{ $rdvEnAttente->count() }}</span>
            </div>

            @if($rdvEnAttente->isEmpty())
                <p class="text-center text-gray-500 py-8 text-sm">Aucune demande en attente</p>
            @else
                <div class="space-y-2">
                    @foreach($rdvEnAttente as $rdv)
                        <div class="p-3 border-l-4 border-yellow-400 bg-yellow-50 rounded">
                            <p class="text-sm font-semibold text-primary">{{ $rdv->client->prenom }} {{ $rdv->client->nom }}</p>
                            <p class="text-xs text-gray-600 mt-1">
                                📅 {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($rdv->heure)->format('H\hi') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ $rdv->type_intervention }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Interventions urgentes --}}
    @if($interventionsUrgentes->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6 mb-8">
            <h2 class="text-lg font-bold text-red-600 mb-4">🚨 Interventions urgentes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($interventionsUrgentes as $int)
                    <div class="border border-red-200 bg-red-50 rounded-lg p-4">
                        <p class="font-semibold text-primary">{{ $int->nature }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            🚗 {{ $int->vehicule->marque }} {{ $int->vehicule->modele }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            👤 {{ $int->vehicule->client->prenom }} {{ $int->vehicule->client->nom }}
                        </p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded font-semibold">URGENT</span>
                            <x-statut-badge :statut="$int->statut" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Actions rapides --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('receptionniste.clients.create') }}"
           class="bg-accent hover:bg-accent-600 text-white p-4 rounded-xl text-center font-semibold transition-all">
            👤 Nouveau client
        </a>
        <a href="{{ route('receptionniste.clients.index') }}"
           class="bg-primary hover:bg-primary-light text-white p-4 rounded-xl text-center font-semibold transition-all">
            📋 Liste clients
        </a>
        <a href="#" class="bg-white border-2 border-gray-200 hover:border-primary text-primary p-4 rounded-xl text-center font-semibold transition-all">
            📅 Rendez-vous
        </a>
        <a href="#" class="bg-white border-2 border-gray-200 hover:border-primary text-primary p-4 rounded-xl text-center font-semibold transition-all">
            🔧 Interventions
        </a>
    </div>
</div>
@endsection