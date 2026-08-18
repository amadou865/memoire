@extends('layouts.authenticated')

@section('title', 'Mes interventions')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Historique des interventions</h1>
        <p class="text-gray-500 mt-1">Suivez toutes les interventions réalisées sur vos véhicules</p>
    </div>

    @if($interventions->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucune intervention pour le moment</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Véhicule</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Nature</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Département</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($interventions as $int)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $int->date_creation->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-primary">{{ $int->vehicule->marque }} {{ $int->vehicule->modele }}</p>
                                <p class="text-xs text-gray-500 font-mono">{{ $int->vehicule->immatriculation }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $int->nature }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $int->departement }}</td>
                            <td class="px-6 py-4"><x-statut-badge :statut="$int->statut" /></td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('client.interventions.show', $int) }}" class="text-primary hover:text-accent font-semibold text-sm">Détails</a>
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