@extends('layouts.authenticated')

@section('title', 'Détail intervention')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('client.interventions.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <div class="flex justify-between items-start mt-2">
            <div>
                <h1 class="text-3xl font-bold text-primary">Intervention #{{ $intervention->id }}</h1>
                <p class="text-gray-500 mt-1">{{ $intervention->nature }}</p>
            </div>
            <x-statut-badge :statut="$intervention->statut" />
        </div>
    </div>

    {{-- Info véhicule --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-bold text-primary mb-4">🚗 Véhicule</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Marque</p>
                <p class="font-semibold text-primary">{{ $intervention->vehicule->marque }}</p>
            </div>
            <div>
                <p class="text-gray-500">Modèle</p>
                <p class="font-semibold text-primary">{{ $intervention->vehicule->modele }}</p>
            </div>
            <div>
                <p class="text-gray-500">Immatriculation</p>
                <p class="font-mono font-semibold text-primary">{{ $intervention->vehicule->immatriculation }}</p>
            </div>
            <div>
                <p class="text-gray-500">Année</p>
                <p class="font-semibold text-primary">{{ $intervention->vehicule->annee }}</p>
            </div>
        </div>
    </div>

    {{-- Info intervention --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-bold text-primary mb-4">🔧 Détails</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Date création</p>
                <p class="font-semibold text-primary">{{ $intervention->date_creation->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Date début</p>
                <p class="font-semibold text-primary">{{ $intervention->date_debut ? $intervention->date_debut->format('d/m/Y') : '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Date fin</p>
                <p class="font-semibold text-primary">{{ $intervention->date_fin ? $intervention->date_fin->format('d/m/Y') : '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Département</p>
                <p class="font-semibold text-primary">{{ $intervention->departement }}</p>
            </div>
            <div>
                <p class="text-gray-500">Priorité</p>
                <p class="font-semibold text-primary">{{ ucfirst($intervention->priorite) }}</p>
            </div>
        </div>
    </div>

    {{-- Diagnostics --}}
    @if($intervention->diagnostics->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-primary mb-4">📋 Diagnostics</h2>
            @foreach($intervention->diagnostics as $diag)
                <div class="border-l-4 border-primary bg-blue-50 rounded p-4 mb-2">
                    <p class="text-sm font-semibold text-primary">{{ ucfirst($diag->type) }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $diag->description }}</p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Devis --}}
    @if($intervention->devis)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">💰 Devis</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Main d'œuvre</span><span class="font-semibold">{{ number_format($intervention->devis->montant_mo, 0, ',', ' ') }} F</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Pièces</span><span class="font-semibold">{{ number_format($intervention->devis->montant_pieces, 0, ',', ' ') }} F</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Diagnostic</span><span class="font-semibold">{{ number_format($intervention->devis->montant_valise, 0, ',', ' ') }} F</span></div>
                <div class="flex justify-between pt-2 border-t border-gray-100 text-base"><span class="font-bold text-primary">TOTAL</span><span class="font-bold text-accent">{{ number_format($intervention->devis->montant_total, 0, ',', ' ') }} F</span></div>
            </div>
        </div>
    @endif
</div>
@endsection