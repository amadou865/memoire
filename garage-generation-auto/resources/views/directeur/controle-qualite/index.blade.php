@extends('layouts.authenticated')

@section('title', 'Contrôle qualité')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">🎯 Contrôle Qualité</h1>
        <p class="text-gray-500 mt-1">Gestion des essais qualité</p>
    </div>

    {{-- Onglets --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-6 inline-flex flex-wrap gap-1">
        <a href="{{ route('directeur.controle-qualite.index', ['filtre' => 'a_controler']) }}"
           class="{{ $filtre === 'a_controler' ? 'bg-accent text-white' : 'text-gray-600 hover:bg-gray-100' }} px-4 py-2 rounded-lg font-semibold text-sm">
            ⏳ À contrôler
        </a>
        <a href="{{ route('directeur.controle-qualite.index', ['filtre' => 'conformes']) }}"
           class="{{ $filtre === 'conformes' ? 'bg-accent text-white' : 'text-gray-600 hover:bg-gray-100' }} px-4 py-2 rounded-lg font-semibold text-sm">
            ✓ Conformes
        </a>
        <a href="{{ route('directeur.controle-qualite.index', ['filtre' => 'non_conformes']) }}"
           class="{{ $filtre === 'non_conformes' ? 'bg-accent text-white' : 'text-gray-600 hover:bg-gray-100' }} px-4 py-2 rounded-lg font-semibold text-sm">
            ✕ Non conformes
        </a>
        <a href="{{ route('directeur.controle-qualite.index', ['filtre' => 'tous']) }}"
           class="{{ $filtre === 'tous' ? 'bg-accent text-white' : 'text-gray-600 hover:bg-gray-100' }} px-4 py-2 rounded-lg font-semibold text-sm">
            📋 Tous
        </a>
    </div>

    @if($interventions->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">
                @if($filtre === 'a_controler')
                    🎉 Aucun contrôle en attente !
                @else
                    Aucune intervention à afficher
                @endif
            </p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date terminée</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Intervention</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Client / Véhicule</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Département</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Résultat</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($interventions as $int)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $int->date_fin?->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-primary text-sm">#{{ $int->id }} - {{ $int->nature }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <p class="font-semibold text-primary">{{ $int->vehicule->client->prenom }} {{ $int->vehicule->client->nom }}</p>
                                <p class="text-xs text-gray-500">{{ $int->vehicule->immatriculation }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $int->departement }}</td>
                            <td class="px-6 py-4">
                                @if($int->essai)
                                    @if($int->essai->resultat === 'conforme')
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-semibold">✓ Conforme</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-semibold">✕ Non conforme</span>
                                    @endif
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-semibold">⏳ À contrôler</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($int->essai)
                                    <a href="{{ route('directeur.controle-qualite.show', $int) }}" class="text-primary hover:text-accent font-semibold text-sm">Voir</a>
                                @else
                                    <a href="{{ route('directeur.controle-qualite.create', $int) }}" class="bg-accent hover:bg-accent-600 text-white font-semibold px-3 py-1.5 rounded text-sm">
                                        Effectuer essai
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $interventions->links() }}</div>
    @endif
</div>
@endsection