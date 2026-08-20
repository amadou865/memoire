@extends('layouts.authenticated')

@section('title', 'Modifier Utilisateur')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ role: '{{ old('role', $utilisateur->role) }}' }">

    <div class="mb-8">
        <a href="{{ route('admin.utilisateurs.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour à la liste</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Modifier un Utilisateur</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.utilisateurs.update', $utilisateur) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            {{-- ════════════════════════════════════════════════════════════ --}}
            {{-- 📍 EMPLACEMENT DU MATRICULE (Affiché uniquement pour les employés) --}}
            {{-- ════════════════════════════════════════════════════════════ --}}
            @if($utilisateur->matricule)
                <div class="bg-primary/5 border border-primary/20 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Matricule Employé</p>
                        <p class="text-xl font-bold font-mono text-primary mt-0.5">
                            {{ $utilisateur->matricule }}
                        </p>
                    </div>
                    <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full">
                        Fixe
                    </span>
                </div>
            @endif

            {{-- Prénom & Nom --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $utilisateur->prenom) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    @error('prenom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom', $utilisateur->nom) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    @error('nom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $utilisateur->email) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Téléphone --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $utilisateur->telephone) }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                @error('telephone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Rôle --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Rôle Utilisateur *</label>
                <select name="role" x-model="role" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="client">Client</option>
                    <option value="receptionniste">Réceptionniste</option>
                    <option value="chef_departement">Chef de Département</option>
                    <option value="directeur_technique">Directeur Technique</option>
                    <option value="administrateur">Administrateur</option>
                </select>
                @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Département si Chef --}}
            <div x-show="role === 'chef_departement'" x-transition class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <label class="block text-sm font-semibold text-primary mb-2">Département Affecté *</label>
                <select name="departement" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="">Sélectionner un département...</option>
                    @foreach($departements as $d)
                        <option value="{{ $d }}" {{ old('departement', $utilisateur->departement) === $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
                @error('departement') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nouveau Mot de Passe (optionnel) --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Nouveau mot de passe (laisser vide si inchangé)</label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Boutons --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.utilisateurs.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">
                    Annuler
                </a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection