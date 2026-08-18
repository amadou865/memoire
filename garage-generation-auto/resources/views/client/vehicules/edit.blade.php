@extends('layouts.authenticated')

@section('title', 'Modifier véhicule')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('client.vehicules.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Modifier le véhicule</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('client.vehicules.update', $vehicule) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Immatriculation *</label>
                <input type="text" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none uppercase">
                @error('immatriculation') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Marque *</label>
                    <input type="text" name="marque" value="{{ old('marque', $vehicule->marque) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Modèle *</label>
                    <input type="text" name="modele" value="{{ old('modele', $vehicule->modele) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Année *</label>
                    <input type="number" name="annee" value="{{ old('annee', $vehicule->annee) }}" min="1980" max="{{ date('Y') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Kilométrage *</label>
                    <input type="number" name="kilometrage" value="{{ old('kilometrage', $vehicule->kilometrage) }}" min="0" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('client.vehicules.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection