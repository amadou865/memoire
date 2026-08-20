@extends('layouts.authenticated')

@section('title', 'Gestion Stock')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Gestion du Stock</h1>
            <p class="text-gray-500 mt-1">Catalogue des pièces détachées</p>
        </div>
        <a href="{{ route('admin.stock.create') }}" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg">
            + Ajouter une Pièce
        </a>
    </div>

    {{-- Filtre --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Référence ou désignation..." class="flex-1 px-4 py-2 border rounded-lg">
            <label class="flex items-center gap-2 px-4">
                <input type="checkbox" name="stock_faible" value="1" {{ $stockFaible ? 'checked' : '' }} onchange="this.form.submit()">
                <span class="text-sm">Stock faible uniquement</span>
            </label>
            <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg">Rechercher</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Référence</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Désignation</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Quantité Stock</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Seuil Alerte</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Prix Unitaire</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pieces as $p)
                    <tr class="hover:bg-gray-50 {{ $p->stockFaible() ? 'bg-red-50/50' : '' }}">
                        <td class="px-6 py-4 font-mono text-sm text-gray-600">{{ $p->reference }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-primary">{{ $p->designation }}</td>
                        <td class="px-6 py-4 text-center font-bold text-primary">{{ $p->quantite_stock }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $p->seuil_alerte }}</td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-accent">{{ number_format($p->prix_unitaire, 0, ',', ' ') }} F</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.stock.edit', $p) }}" class="text-primary font-semibold text-sm">Modifier</a>
                            <form action="{{ route('admin.stock.destroy', $p) }}" method="POST" onsubmit="return confirm('Supprimer ?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500 font-semibold text-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $pieces->links() }}</div>
</div>
@endsection