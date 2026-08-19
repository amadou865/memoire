@extends('layouts.authenticated')

@section('title', 'Modifier devis')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.devis.show', $devi) }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Modifier {{ $devi->numero }}</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
         x-data="{
            mo: {{ $devi->montant_mo }},
            pieces: {{ $devi->montant_pieces }},
            valise: {{ $devi->montant_valise }},
            get total() { return parseFloat(this.mo || 0) + parseFloat(this.pieces || 0) + parseFloat(this.valise || 0); },
            format(n) { return new Intl.NumberFormat('fr-FR').format(n); }
         }">

        <form action="{{ route('receptionniste.devis.update', $devi) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Main d'œuvre (F CFA)</label>
                <input type="number" name="montant_mo" x-model="mo" min="0" step="500" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Pièces (F CFA)</label>
                <input type="number" name="montant_pieces" x-model="pieces" min="0" step="500" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Diagnostic (F CFA)</label>
                <input type="number" name="montant_valise" x-model="valise" min="0" step="500" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
            </div>

            <div class="bg-accent/10 border-2 border-accent rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-primary text-lg">TOTAL</span>
                    <span class="font-bold text-accent text-2xl" x-text="format(total) + ' F CFA'"></span>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('receptionniste.devis.show', $devi) }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection