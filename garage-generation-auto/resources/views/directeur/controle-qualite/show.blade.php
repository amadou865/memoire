@extends('layouts.authenticated')

@section('title', 'Détail essai')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('directeur.controle-qualite.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <div class="flex justify-between items-start mt-2">
            <div>
                <h1 class="text-3xl font-bold text-primary">Essai qualité #{{ $intervention->essai->id }}</h1>
                <p class="text-gray-500 mt-1">Intervention #{{ $intervention->id }} - {{ $intervention->nature }}</p>
            </div>
            @if($intervention->essai->resultat === 'conforme')
                <span class="bg-green-100 text-green-800 text-lg px-4 py-2 rounded-lg font-bold">✓ CONFORME</span>
            @else
                <span class="bg-red-100 text-red-800 text-lg px-4 py-2 rounded-lg font-bold">✕ NON CONFORME</span>
            @endif
        </div>
    </div>

    {{-- Info essai --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-bold text-primary mb-4">📋 Détails de l'essai</h2>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500">Date de l'essai</span>
                <span class="font-semibold text-primary">{{ $intervention->essai->date->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
                <span class="text-gray-500">Heure de validation</span>
                <span class="font-semibold text-primary">{{ $intervention->essai->heure_validation->format('H:i:s') }}</span>
            </div>
            @if($intervention->essai->observations)
                <div class="pt-2">
                    <p class="text-gray-500 mb-1">Observations</p>
                    <p class="text-primary bg-blue-50 rounded p-3">{{ $intervention->essai->observations }}</p>
                </div>
            @endif
            @if($intervention->essai->motif_non_conformite)
                <div class="pt-2">
                    <p class="text-red-600 font-semibold mb-1">⚠️ Motif de non-conformité</p>
                    <p class="text-red-800 bg-red-50 border border-red-200 rounded p-3">{{ $intervention->essai->motif_non_conformite }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Récap intervention --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-primary mb-4">📋 Intervention contrôlée</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs text-gray-500 uppercase">Client</p>
                <p class="font-semibold text-primary">{{ $intervention->vehicule->client->prenom }} {{ $intervention->vehicule->client->nom }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Véhicule</p>
                <p class="font-semibold text-primary">{{ $intervention->vehicule->marque }} {{ $intervention->vehicule->modele }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Nature</p>
                <p class="font-semibold text-primary">{{ $intervention->nature }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Département</p>
                <p class="font-semibold text-primary">{{ $intervention->departement }}</p>
            </div>
        </div>
    </div>
</div>
@endsection