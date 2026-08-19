@extends('layouts.authenticated')

@section('title', 'Factures')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Factures</h1>
        <p class="text-gray-500 mt-1">Gérez les factures et paiements</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('receptionniste.factures.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-primary transition-all">
            <p class="text-gray-500 text-xs uppercase font-semibold">Total</p>
            <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total'] }}</p>
        </a>
        <a href="{{ route('receptionniste.factures.index', ['statut' => 'en_attente']) }}" class="bg-yellow-50 rounded-xl border border-yellow-200 p-4 hover:border-yellow-400 transition-all">
            <p class="text-yellow-700 text-xs uppercase font-semibold">En attente</p>
            <p class="text-2xl font-bold text-yellow-800 mt-1">{{ $stats['en_attente'] }}</p>
        </a>
        <a href="{{ route('receptionniste.factures.index', ['statut' => 'paye']) }}" class="bg-green-50 rounded-xl border border-green-200 p-4 hover:border-green-400 transition-all">
            <p class="text-green-700 text-xs uppercase font-semibold">Payées</p>
            <p class="text-2xl font-bold text-green-800 mt-1">{{ $stats['paye'] }}</p>
        </a>
        <div class="bg-purple-50 rounded-xl border border-purple-200 p-4">
            <p class="text-purple-700 text-xs uppercase font-semibold">Chiffre d'affaires</p>
            <p class="text-xl font-bold text-purple-800 mt-1">{{ number_format($stats['montant_total'], 0, ',', ' ') }} F</p>
        </div>
    </div>

    {{-- Liste --}}
    @if($factures->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucune facture trouvée</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">N° Facture</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Client</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Montant</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Paiement</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($factures as $f)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-sm font-semibold text-primary">{{ $f->numero }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $f->date_emission->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <p class="font-semibold text-primary">{{ $f->devis->intervention->vehicule->client->prenom }} {{ $f->devis->intervention->vehicule->client->nom }}</p>
                                <p class="text-xs text-gray-500">{{ $f->devis->intervention->vehicule->immatriculation }}</p>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-accent">{{ number_format($f->montant_total, 0, ',', ' ') }} F</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($f->mode_payement ?? '—') }}</td>
                            <td class="px-6 py-4"><x-statut-badge :statut="$f->statut" /></td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('receptionniste.factures.show', $f) }}" class="text-primary hover:text-accent font-semibold text-sm">Détails</a>
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