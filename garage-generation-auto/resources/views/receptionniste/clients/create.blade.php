@extends('layouts.authenticated')

@section('title', 'Nouveau client')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.clients.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Nouveau client</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('receptionniste.clients.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    @error('prenom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    @error('nom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Téléphone *</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="+221 77 000 00 00" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                @error('telephone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Mot de passe *</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Confirmation *</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('receptionniste.clients.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">
                    Créer le client
                </button>
            </div>
        </form>
    </div>
</div>
@endsection