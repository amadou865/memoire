@extends('layouts.authenticated')

@section('title', 'Modifier client')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.clients.show', $client) }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Modifier le client</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('receptionniste.clients.update', $client) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $client->prenom) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    @error('prenom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom', $client->nom) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    @error('nom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Téléphone *</label>
                <input type="text" name="telephone" value="{{ old('telephone', $client->telephone) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                @error('telephone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('receptionniste.clients.show', $client) }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection