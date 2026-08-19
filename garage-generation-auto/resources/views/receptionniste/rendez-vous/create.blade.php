@extends('layouts.authenticated')

@section('title', 'Nouveau rendez-vous')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.rendez-vous.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Créer un rendez-vous</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('receptionniste.rendez-vous.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Client *</label>
                <select name="client_id" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    <option value="">Sélectionner un client...</option>
                    @foreach($clients as $c)
                        <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->prenom }} {{ $c->nom }} ({{ $c->telephone }})
                        </option>
                    @endforeach
                </select>
                @error('client_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Date *</label>
                    <input type="date" name="date" value="{{ old('date') }}" min="{{ date('Y-m-d') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Heure *</label>
                    <select name="heure" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                        <option value="">Choisir...</option>
                        @foreach(['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'] as $h)
                            <option value="{{ $h }}" {{ old('heure') === $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('heure') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Type d'intervention *</label>
                <select name="type_intervention" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    <option value="">Choisir...</option>
                    @foreach(['Vidange', 'Révision', 'Diagnostic', 'Réparation freinage', 'Climatisation', 'Électricité', 'Tôlerie', 'Peinture', 'Autre'] as $type)
                        <option value="{{ $type }}" {{ old('type_intervention') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @error('type_intervention') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Statut *</label>
                <select name="statut" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
                    <option value="confirme">Confirmé (recommandé)</option>
                    <option value="en_attente">En attente</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('receptionniste.rendez-vous.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">Créer le RDV</button>
            </div>
        </form>
    </div>
</div>
@endsection