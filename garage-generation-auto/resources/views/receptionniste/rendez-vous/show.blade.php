@extends('layouts.authenticated')

@section('title', 'Détail RDV')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.rendez-vous.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <div class="flex justify-between items-start mt-2">
            <div>
                <h1 class="text-3xl font-bold text-primary">Rendez-vous #{{ $rendezVou->id }}</h1>
                <p class="text-gray-500 mt-1">{{ $rendezVou->type_intervention }}</p>
            </div>
            <x-statut-badge :statut="$rendezVou->statut" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        {{-- Info RDV --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">📅 Rendez-vous</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Date</span>
                    <span class="font-semibold text-primary">{{ \Carbon\Carbon::parse($rendezVou->date)->locale('fr')->translatedFormat('l d F Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Heure</span>
                    <span class="font-semibold text-primary">{{ \Carbon\Carbon::parse($rendezVou->heure)->format('H\hi') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Type</span>
                    <span class="font-semibold text-primary">{{ $rendezVou->type_intervention }}</span>
                </div>
                @if($rendezVou->description)
                    <div class="pt-2">
                        <span class="text-gray-500 block mb-1">Description</span>
                        <p class="text-primary">{{ $rendezVou->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Client --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">👤 Client</h2>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="font-bold text-primary text-lg">{{ $rendezVou->client->prenom }} {{ $rendezVou->client->nom }}</p>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Email</span>
                    <span class="font-semibold text-primary">{{ $rendezVou->client->email }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Téléphone</span>
                    <span class="font-semibold text-primary">{{ $rendezVou->client->telephone }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Véhicules</span>
                    <span class="font-semibold text-primary">{{ $rendezVou->client->vehicules->count() }}</span>
                </div>
            </div>
            <a href="{{ route('receptionniste.clients.show', $rendezVou->client) }}" class="mt-4 block text-center bg-primary/10 hover:bg-primary/20 text-primary font-semibold py-2 rounded-lg text-sm">
                Voir la fiche complète
            </a>
        </div>
    </div>

    {{-- Actions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-primary mb-4">⚡ Actions</h2>
        <div class="flex flex-wrap gap-3">
            @if($rendezVou->statut === 'en_attente')
                <form action="{{ route('receptionniste.rendez-vous.valider', $rendezVou) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">✓ Valider le RDV</button>
                </form>
                <form action="{{ route('receptionniste.rendez-vous.refuser', $rendezVou) }}" method="POST" onsubmit="return confirm('Refuser ce RDV ?')" class="inline">
                    @csrf @method('PATCH')
                    <button class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-sm">✕ Refuser</button>
                </form>
            @endif

            @if($rendezVou->statut === 'confirme' && !$rendezVou->intervention)
                <a href="{{ route('receptionniste.interventions.create', ['rdv_id' => $rendezVou->id]) }}" class="bg-accent hover:bg-accent-600 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                    🔧 Créer l'intervention
                </a>
            @endif

            @if($rendezVou->intervention)
                <a href="{{ route('receptionniste.interventions.show', $rendezVou->intervention) }}" class="bg-primary hover:bg-primary-light text-white font-semibold px-4 py-2 rounded-lg text-sm">
                    Voir l'intervention →
                </a>
            @endif

            <form action="{{ route('receptionniste.rendez-vous.destroy', $rendezVou) }}" method="POST" onsubmit="return confirm('Supprimer ce RDV ?')" class="inline">
                @csrf @method('DELETE')
                <button class="border border-red-200 text-red-500 hover:bg-red-50 font-semibold px-4 py-2 rounded-lg text-sm">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection