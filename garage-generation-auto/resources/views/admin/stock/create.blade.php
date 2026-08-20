@extends('layouts.authenticated')

@section('title', 'Ajouter Pièce')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('admin.stock.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Nouvelle Pièce Détachée</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.stock.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Référence *</label>
                <input type="text" name="reference" value="{{ old('reference') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg uppercase">
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Désignation *</label>
                <input type="text" name="designation" value="{{ old('designation') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Quantité initiale *</label>
                    <input type="number" name="quantite_stock" value="{{ old('quantite_stock', 10) }}" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Seuil d'alerte *</label>
                    <input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', 3) }}" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Prix unitaire (F CFA) *</label>
                <input type="number" name="prix_unitaire" value="{{ old('prix_unitaire') }}" min="0" step="500" required class="w-full px-4 py-3 border border-gray-200 rounded-lg">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.stock.index') }}" class="px-5 py-2.5 border rounded-lg">Annuler</a>
                <button type="submit" class="bg-accent text-white font-semibold px-5 py-2.5 rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection