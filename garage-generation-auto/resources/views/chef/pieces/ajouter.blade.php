@extends('layouts.authenticated')

@section('title', 'Ajouter une pièce')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{
    pieceId: '',
    quantite: 1,
    pieces: @js($pieces->map(fn($p) => ['id' => $p->id, 'ref' => $p->reference, 'des' => $p->designation, 'stock' => $p->quantite_stock, 'prix' => $p->prix_unitaire])),
    get selectedPiece() { return this.pieces.find(p => p.id == this.pieceId); },
    get sousTotal() { return this.selectedPiece ? this.selectedPiece.prix * this.quantite : 0; },
    format(n) { return new Intl.NumberFormat('fr-FR').format(n); }
}">

    <div class="mb-8">
        <a href="{{ route('chef.interventions.show', $intervention) }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Ajouter une pièce</h1>
        <p class="text-sm text-gray-500 mt-1">Intervention #{{ $intervention->id }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('chef.pieces.store', $intervention) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Pièce détachée *</label>
                <select name="piece_id" x-model="pieceId" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="">Sélectionner une pièce...</option>
                    @foreach($pieces as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->reference }} - {{ $p->designation }} (Stock: {{ $p->quantite_stock }})
                        </option>
                    @endforeach
                </select>
                @error('piece_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Info pièce sélectionnée --}}
            <div x-show="selectedPiece" x-transition class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Stock disponible</p>
                        <p class="font-bold text-primary" x-text="selectedPiece?.stock + ' unités'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Prix unitaire</p>
                        <p class="font-bold text-primary" x-text="format(selectedPiece?.prix) + ' F CFA'"></p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Quantité *</label>
                <input type="number" name="quantite_utilisee" x-model="quantite" min="1"
                       :max="selectedPiece?.stock" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                <p x-show="selectedPiece && quantite > selectedPiece.stock" class="text-red-500 text-xs mt-1">
                    ⚠️ Stock insuffisant !
                </p>
            </div>

            {{-- Sous-total --}}
            <div x-show="selectedPiece" class="bg-accent/10 border-2 border-accent rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-primary">Sous-total</span>
                    <span class="font-bold text-accent text-xl" x-text="format(sousTotal) + ' F CFA'"></span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Observations (facultatif)</label>
                <textarea name="observations" rows="2" placeholder="Notes sur l'utilisation..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">{{ old('observations') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('chef.interventions.show', $intervention) }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit"
                        :disabled="!selectedPiece || quantite > selectedPiece?.stock"
                        :class="!selectedPiece || quantite > selectedPiece?.stock ? 'opacity-50 cursor-not-allowed' : ''"
                        class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">
                    Ajouter la pièce
                </button>
            </div>
        </form>
    </div>
</div>
@endsection