@extends('layouts.authenticated')

@section('title', 'Nouvelle intervention')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{
    clientId: '{{ $rendezVous?->client_id ?? old('client_id') }}',
    clients: @js($clients->map(fn($c) => ['id' => $c->id, 'nom' => $c->nom, 'prenom' => $c->prenom, 'vehicules' => $c->vehicules->toArray()])),
    get selectedVehicules() {
        const c = this.clients.find(cl => cl.id == this.clientId);
        return c ? c.vehicules : [];
    }
}">

    <div class="mb-8">
        <a href="{{ route('receptionniste.interventions.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Créer une intervention</h1>
        @if($rendezVous)
            <p class="text-sm text-gray-500 mt-1">Depuis le RDV #{{ $rendezVous->id }} : {{ $rendezVous->type_intervention }}</p>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('receptionniste.interventions.store') }}" method="POST" class="space-y-6">
            @csrf

            @if($rendezVous)
                <input type="hidden" name="rendez_vous_id" value="{{ $rendezVous->id }}">
            @endif

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Client *</label>
                <select x-model="clientId" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="">Sélectionner...</option>
                    @foreach($clients as $c)
                        <option value="{{ $c->id }}">{{ $c->prenom }} {{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Véhicule *</label>
                <select name="vehicule_id" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                    <option value="">Sélectionner un véhicule...</option>
                    <template x-for="v in selectedVehicules" :key="v.id">
                        <option :value="v.id" x-text="`${v.marque} ${v.modele} - ${v.immatriculation}`"></option>
                    </template>
                </select>
                @error('vehicule_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-500 mt-1" x-show="clientId && selectedVehicules.length === 0">
                    ⚠️ Ce client n'a aucun véhicule enregistré
                </p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Nature des travaux *</label>
                <input type="text" name="nature" value="{{ old('nature', $rendezVous?->type_intervention) }}" required placeholder="Ex: Vidange complète + filtre à huile"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                @error('nature') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Département *</label>
                    <select name="departement" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                        <option value="">Choisir...</option>
                        @foreach($departements as $d)
                            <option value="{{ $d }}" {{ old('departement') === $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                    @error('departement') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Priorité *</label>
                    <select name="priorite" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
                        <option value="normale" {{ old('priorite', 'normale') === 'normale' ? 'selected' : '' }}>Normale</option>
                        <option value="faible" {{ old('priorite') === 'faible' ? 'selected' : '' }}>Faible</option>
                        <option value="haute" {{ old('priorite') === 'haute' ? 'selected' : '' }}>Haute</option>
                        <option value="urgente" {{ old('priorite') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-primary mb-2">Date de début (optionnel)</label>
                <input type="datetime-local" name="date_debut" value="{{ old('date_debut') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent outline-none">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('receptionniste.interventions.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold">Annuler</a>
                <button type="submit" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg">Créer</button>
            </div>
        </form>
    </div>
</div>
@endsection