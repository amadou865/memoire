@extends('layouts.authenticated')

@section('title', 'Nouveau diagnostic')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ type: 'visuel' }">

    <div class="mb-8">
        <a href="{{ route('chef.interventions.show', $intervention) }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Nouveau diagnostic</h1>
        <p class="text-sm text-gray-500 mt-1">Intervention #{{ $intervention->id }} : {{ $intervention->nature }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('chef.diagnostics.store', $intervention) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Type de diagnostic --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Type de diagnostic *</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="visuel" x-model="type" class="sr-only" checked>
                        <div :class="type === 'visuel' ? 'border-accent bg-orange-50' : 'border-gray-200'"
                             class="border-2 rounded-lg p-4 text-center transition-all">
                            <div class="text-2xl mb-1">👁️</div>
                            <p class="font-bold text-primary">Visuel</p>
                            <p class="text-xs text-gray-500">Inspection visuelle</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="valise" x-model="type" class="sr-only">
                        <div :class="type === 'valise' ? 'border-accent bg-orange-50' : 'border-gray-200'"
                             class="border-2 rounded-lg p-4 text-center transition-all">
                            <div class="text-2xl mb-1">🔌</div>
                            <p class="font-bold text-primary">Valise</p>
                            <p class="text-xs text-gray-500">Diagnostic électronique</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Description *</label>
                <textarea name="description" rows="3" required placeholder="Décrivez le problème identifié..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Codes défauts (uniquement valise) --}}
            <div x-show="type === 'valise'" x-transition>
                <label class="block text-sm font-semibold text-primary mb-2">Codes défauts</label>
                <input type="text" name="codes_defauts" value="{{ old('codes_defauts') }}" placeholder="Ex: P0300, P0171"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none font-mono">
                <p class="text-xs text-gray-500 mt-1">Séparez les codes par des virgules</p>
            </div>

            {{-- Observations --}}
            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Observations / Préconisations</label>
                <textarea name="observations" rows="3" placeholder="Recommandations, pièces à changer..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">{{ old('observations') }}</textarea>
            </div>

            {{-- Coût valise (uniquement valise) --}}
            <div x-show="type === 'valise'" x-transition>
                <label class="block text-sm font-semibold text-primary mb-2">Coût diagnostic valise (F CFA)</label>
                <input type="number" name="cout_valise" value="{{ old('cout_valise', 0) }}" min="0" step="500"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('chef.interventions.show', $intervention) }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">
                    📤 Transmettre au réceptionniste
                </button>
            </div>
        </form>
    </div>
</div>
@endsection