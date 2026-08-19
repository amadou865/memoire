@extends('layouts.authenticated')

@section('title', 'Modifier intervention')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.interventions.show', $intervention) }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Modifier intervention #{{ $intervention->id }}</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('receptionniste.interventions.update', $intervention) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Nature *</label>
                <input type="text" name="nature" value="{{ old('nature', $intervention->nature) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Département *</label>
                    <select name="departement" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                        @foreach($departements as $d)
                            <option value="{{ $d }}" {{ old('departement', $intervention->departement) === $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Priorité *</label>
                    <select name="priorite" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                        <option value="faible" {{ $intervention->priorite === 'faible' ? 'selected' : '' }}>Faible</option>
                        <option value="normale" {{ $intervention->priorite === 'normale' ? 'selected' : '' }}>Normale</option>
                        <option value="haute" {{ $intervention->priorite === 'haute' ? 'selected' : '' }}>Haute</option>
                        <option value="urgente" {{ $intervention->priorite === 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Statut *</label>
                <select name="statut" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="planifiee" {{ $intervention->statut === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                    <option value="en_cours" {{ $intervention->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="terminee" {{ $intervention->statut === 'terminee' ? 'selected' : '' }}>Terminée</option>
                    <option value="annulee" {{ $intervention->statut === 'annulee' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Date début</label>
                    <input type="datetime-local" name="date_debut" value="{{ old('date_debut', $intervention->date_debut?->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Date fin</label>
                    <input type="datetime-local" name="date_fin" value="{{ old('date_fin', $intervention->date_fin?->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('receptionniste.interventions.show', $intervention) }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection