@extends('layouts.authenticated')

@section('title', 'Fiche client')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.clients.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour à la liste</a>
    </div>

    {{-- Header client --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($client->prenom, 0, 1)) }}{{ strtoupper(substr($client->nom, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-primary">{{ $client->prenom }} {{ $client->nom }}</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        📧 {{ $client->email }} &nbsp;|&nbsp; 📞 {{ $client->telephone ?? '—' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Client depuis le {{ $client->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <a href="{{ route('receptionniste.clients.edit', $client) }}"
               class="bg-primary hover:bg-primary-light text-white font-semibold px-4 py-2 rounded-lg text-sm">
                Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Véhicules --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">🚗 Véhicules ({{ $client->vehicules->count() }})</h2>
            @if($client->vehicules->isEmpty())
                <p class="text-gray-500 text-sm text-center py-4">Aucun véhicule enregistré</p>
            @else
                <div class="space-y-2">
                    @foreach($client->vehicules as $v)
                        <div class="border border-gray-100 rounded-lg p-3 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-primary text-sm">{{ $v->marque }} {{ $v->modele }}</p>
                                <p class="text-xs text-gray-500">{{ $v->annee }} • {{ number_format($v->kilometrage, 0, ',', ' ') }} km</p>
                            </div>
                            <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $v->immatriculation }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Derniers RDV --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">📅 Derniers RDV</h2>
            @if($client->rendezVousClient->isEmpty())
                <p class="text-gray-500 text-sm text-center py-4">Aucun rendez-vous</p>
            @else
                <div class="space-y-2">
                    @foreach($client->rendezVousClient as $rdv)
                        <div class="border-l-4 border-primary bg-blue-50 rounded p-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-semibold text-primary">{{ $rdv->type_intervention }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($rdv->heure)->format('H\hi') }}</p>
                                </div>
                                <x-statut-badge :statut="$rdv->statut" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Interventions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
        <h2 class="text-lg font-bold text-primary mb-4">🔧 Historique interventions ({{ $interventions->count() }})</h2>
        @if($interventions->isEmpty())
            <p class="text-gray-500 text-sm text-center py-4">Aucune intervention</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Véhicule</th>
                        <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Nature</th>
                        <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($interventions as $int)
                        <tr>
                            <td class="py-3 text-gray-600">{{ $int->date_creation->format('d/m/Y') }}</td>
                            <td class="py-3 text-gray-600">{{ $int->vehicule->marque }} {{ $int->vehicule->modele }}</td>
                            <td class="py-3 text-gray-600">{{ $int->nature }}</td>
                            <td class="py-3"><x-statut-badge :statut="$int->statut" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection