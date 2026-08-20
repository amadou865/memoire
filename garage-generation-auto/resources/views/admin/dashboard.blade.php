@extends('layouts.authenticated')

@section('title', 'Administration')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-primary">👑 Espace Administration</h1>
            <p class="text-gray-500 mt-1">Vue d'ensemble de Génération Automobile</p>
        </div>
        <span class="bg-primary/10 text-primary px-4 py-2 rounded-xl text-sm font-bold">Super Admin</span>
    </div>

    {{-- Stats globales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">Interventions (Mois)</p>
            <p class="text-3xl font-bold text-primary mt-1">{{ $interventionsMois }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">Chiffre d'affaires (Mois)</p>
            <p class="text-2xl font-bold text-accent mt-1">{{ number_format($caMensuel, 0, ',', ' ') }} F</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">Utilisateurs</p>
            <p class="text-3xl font-bold text-primary mt-1">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">Stock Faible</p>
            <p class="text-3xl font-bold text-{{ $stockFaibleCount > 0 ? 'red' : 'green' }}-600 mt-1">{{ $stockFaibleCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Alertes Stock --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-primary">⚠️ Alertes Stock</h2>
                <a href="{{ route('admin.stock.index', ['stock_faible' => 1]) }}" class="text-sm text-accent font-semibold hover:underline">Gérer →</a>
            </div>

            @if($piecesAlerte->isEmpty())
                <p class="text-center text-gray-500 py-8 text-sm">Stock en parfait état ✓</p>
            @else
                <div class="space-y-2">
                    @foreach($piecesAlerte as $p)
                        <div class="p-3 border-l-4 border-red-500 bg-red-50 rounded flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold text-primary">{{ $p->designation }}</p>
                                <p class="text-xs text-gray-500 font-mono">{{ $p->reference }}</p>
                            </div>
                            <span class="text-xs font-bold text-red-600 bg-white px-2 py-1 rounded shadow-sm">
                                {{ $p->quantite_stock }} / {{ $p->seuil_alerte }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Activité récente --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-primary">🔧 Dernières interventions</h2>
            </div>

            <div class="space-y-3">
                @foreach($interventionsRecentes as $int)
                    <div class="p-3 border border-gray-100 rounded-lg flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-primary text-sm">#{{ $int->id }} - {{ $int->nature }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $int->vehicule->client->prenom }} {{ $int->vehicule->client->nom }} • {{ $int->departement }}
                            </p>
                        </div>
                        <x-statut-badge :statut="$int->statut" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Raccourcis Administrateur --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.utilisateurs.index') }}" class="bg-primary hover:bg-primary-light text-white p-4 rounded-xl text-center font-semibold transition-all">
            👥 Utilisateurs
        </a>
        <a href="{{ route('admin.stock.index') }}" class="bg-accent hover:bg-accent-600 text-white p-4 rounded-xl text-center font-semibold transition-all">
            📦 Stock
        </a>
        <a href="{{ route('admin.statistiques') }}" class="bg-white border-2 border-gray-200 hover:border-primary text-primary p-4 rounded-xl text-center font-semibold transition-all">
            📊 Statistiques
        </a>
        <a href="{{ route('admin.parametres') }}" class="bg-white border-2 border-gray-200 hover:border-primary text-primary p-4 rounded-xl text-center font-semibold transition-all">
            ⚙️ Paramètres
        </a>
    </div>
</div>
@endsection