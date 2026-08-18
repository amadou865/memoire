@extends('layouts.authenticated')

@section('title', 'Mes véhicules')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Mes véhicules</h1>
            <p class="text-gray-500 mt-1">{{ $vehicules->count() }} véhicule(s) enregistré(s)</p>
        </div>
        <a href="{{ route('client.vehicules.create') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un véhicule
        </a>
    </div>

    @if($vehicules->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1" />
                </svg>
            </div>
            <p class="text-gray-500 mb-4">Vous n'avez encore aucun véhicule enregistré</p>
            <a href="{{ route('client.vehicules.create') }}" class="text-accent font-semibold hover:underline">
                Ajouter mon premier véhicule →
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vehicules as $vehicule)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1" />
                            </svg>
                        </div>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded font-mono">{{ $vehicule->immatriculation }}</span>
                    </div>

                    <h3 class="text-xl font-bold text-primary">{{ $vehicule->marque }} {{ $vehicule->modele }}</h3>
                    <p class="text-gray-500 text-sm mt-1">Année {{ $vehicule->annee }}</p>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-sm">
                        <span class="text-gray-600">{{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</span>
                        <div class="flex gap-2">
                            <a href="{{ route('client.vehicules.edit', $vehicule) }}" class="text-primary hover:text-accent font-semibold">
                                Modifier
                            </a>
                            <form action="{{ route('client.vehicules.destroy', $vehicule) }}" method="POST" onsubmit="return confirm('Supprimer ce véhicule ?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection