@extends('layouts.authenticated')

@section('title', 'Mes factures')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Mes factures</h1>
        <p class="text-gray-500 mt-1">Consultez et téléchargez vos factures</p>
    </div>

    @if($factures->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucune facture pour le moment</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">N° Facture</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Véhicule</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Montant</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($factures as $facture)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-sm font-semibold text-primary">{{ $facture->numero }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $facture->date_emission->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $facture->devis->intervention->vehicule->marque }} {{ $facture->devis->intervention->vehicule->modele }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-accent">{{ number_format($facture->montant_total, 0, ',', ' ') }} F</td>
                            <td class="px-6 py-4"><x-statut-badge :statut="$facture->statut" /></td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-primary hover:text-accent text-sm font-semibold">Télécharger PDF</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $factures->links() }}</div>
    @endif
</div>
@endsection