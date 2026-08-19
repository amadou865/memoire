@extends('layouts.authenticated')

@section('title', 'Devis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Devis</h1>
            <p class="text-gray-500 mt-1">Gérez les devis clients</p>
        </div>
        <a href="{{ route('receptionniste.devis.create') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20">
            + Nouveau devis
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('receptionniste.devis.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-primary transition-all">
            <p class="text-gray-500 text-xs uppercase font-semibold">Total</p>
            <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total'] }}</p>
        </a>
        <a href="{{ route('receptionniste.devis.index', ['statut' => 'brouillon']) }}" class="bg-gray-50 rounded-xl border border-gray-200 p-4 hover:border-gray-400 transition-all">
            <p class="text-gray-700 text-xs uppercase font-semibold">Brouillons</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['brouillon'] }}</p>
        </a>
        <a href="{{ route('receptionniste.devis.index', ['statut' => 'valide']) }}" class="bg-green-50 rounded-xl border border-green-200 p-4 hover:border-green-400 transition-all">
            <p class="text-green-700 text-xs uppercase font-semibold">Validés</p>
            <p class="text-2xl font-bold text-green-800 mt-1">{{ $stats['valide'] }}</p>
        </a>
        <a href="{{ route('receptionniste.devis.index', ['statut' => 'facture']) }}" class="bg-purple-50 rounded-xl border border-purple-200 p-4 hover:border-purple-400 transition-all">
            <p class="text-purple-700 text-xs uppercase font-semibold">Facturés</p>
            <p class="text-2xl font-bold text-purple-800 mt-1">{{ $stats['facture'] }}</p>
        </a>
    </div>

    {{-- Liste --}}
    @if($devis->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucun devis trouvé</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">N° Devis</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Client</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Intervention</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Montant</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($devis as $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-sm font-semibold text-primary">{{ $d->numero }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $d->date_creation->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <p class="font-semibold text-primary">{{ $d->intervention->vehicule->client->prenom }} {{ $d->intervention->vehicule->client->nom }}</p>
                                <p class="text-xs text-gray-500">{{ $d->intervention->vehicule->immatriculation }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($d->intervention->nature, 30) }}</td>
                            <td class="px-6 py-4 text-right font-bold text-accent">{{ number_format($d->montant_total, 0, ',', ' ') }} F</td>
                            <td class="px-6 py-4"><x-statut-badge :statut="$d->statut" /></td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('receptionniste.devis.show', $d) }}" class="text-primary hover:text-accent font-semibold text-sm">Détails</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $devis->links() }}</div>
    @endif
</div>
@endsection