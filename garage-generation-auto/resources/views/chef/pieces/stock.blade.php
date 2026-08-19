@extends('layouts.authenticated')

@section('title', 'Stock des pièces')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">📦 Stock des pièces détachées</h1>
        <p class="text-gray-500 mt-1">Consultation du stock (lecture seule)</p>
    </div>

    {{-- Recherche --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par référence ou désignation..."
                   class="flex-1 px-4 py-2 border border-gray-200 rounded-lg">
            <label class="flex items-center gap-2 px-4">
                <input type="checkbox" name="stock_faible" value="1" {{ $stockFaible ? 'checked' : '' }} onchange="this.form.submit()" class="rounded">
                <span class="text-sm text-gray-600">Stock faible uniquement</span>
            </label>
            <button type="submit" class="bg-primary hover:bg-primary-light text-white font-semibold px-5 py-2 rounded-lg">Rechercher</button>
        </form>
    </div>

    @if($pieces->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucune pièce trouvée</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Référence</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Désignation</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Stock</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Seuil</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Prix</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">État</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pieces as $p)
                        <tr class="hover:bg-gray-50 {{ $p->stockFaible() ? 'bg-red-50/50' : '' }}">
                            <td class="px-6 py-4 font-mono text-sm text-gray-600">{{ $p->reference }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-primary">{{ $p->designation }}</td>
                            <td class="px-6 py-4 text-center font-bold text-primary">{{ $p->quantite_stock }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $p->seuil_alerte }}</td>
                            <td class="px-6 py-4 text-right text-sm font-semibold">{{ number_format($p->prix_unitaire, 0, ',', ' ') }} F</td>
                            <td class="px-6 py-4 text-center">
                                @if($p->quantite_stock === 0)
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-semibold">✕ Rupture</span>
                                @elseif($p->stockFaible())
                                    <span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded font-semibold">⚠ Faible</span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-semibold">✓ OK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $pieces->links() }}</div>
    @endif
</div>
@endsection