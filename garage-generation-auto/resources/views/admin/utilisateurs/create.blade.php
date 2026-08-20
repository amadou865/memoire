@extends('layouts.authenticated')

@section('title', 'Créer Utilisateur')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="{
        role: '{{ old('role', 'receptionniste') }}',
        matriculesMap: @js($nextMatricules),
        get previewMatricule() {
            return this.matriculesMap[this.role] || '';
        }
     }">

    <div class="mb-8">
        <a href="{{ route('admin.utilisateurs.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour à la liste</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Créer un Compte Utilisateur</h1>
        <p class="text-gray-500 text-sm mt-1">Un matricule sera attribué automatiquement aux employés du garage.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.utilisateurs.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Aperçu du Matricule Réel (Masqué si Client) --}}
            <div x-show="role !== 'client'" x-transition class="bg-primary/5 border border-primary/20 rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Matricule Employé</p>
                    <p class="text-xl font-bold font-mono text-accent mt-0.5" x-text="previewMatricule"></p>
                </div>
                <span class="bg-accent/10 text-accent text-xs font-semibold px-3 py-1 rounded-full">
                    Généré
                </span>
            </div>

            {{-- Prénom & Nom --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    @error('prenom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    @error('nom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Téléphone --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="+221 77 000 00 00"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                @error('telephone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Choix du Rôle --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Rôle Utilisateur *</label>
                <select name="role" x-model="role" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="receptionniste">Réceptionniste</option>
                    <option value="chef_departement">Chef de Département</option>
                    <option value="directeur_technique">Directeur Technique</option>
                    <option value="administrateur">Administrateur</option>
                    <option value="client">Client</option>
                </select>
                @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Champ Spécifique Chef de Département --}}
            <div x-show="role === 'chef_departement'" x-transition class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <label class="block text-sm font-semibold text-primary mb-2">Département Affecté *</label>
                <select name="departement" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="">Sélectionner un département...</option>
                    @foreach($departements as $d)
                        <option value="{{ $d }}" {{ old('departement') === $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
                @error('departement') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Mot de passe --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Mot de passe initial *</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Boutons --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.utilisateurs.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">
                    Annuler
                </a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20">
                    Créer Utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection