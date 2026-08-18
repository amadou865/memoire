@extends('layouts.authenticated')

@section('title', 'Prendre un rendez-vous')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('client.rendez-vous.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <h1 class="text-3xl font-bold text-primary mt-2">Prendre un rendez-vous</h1>
        <p class="text-gray-500 mt-1">Choisissez une date puis un créneau horaire disponible</p>
    </div>

    <div x-data="rdvBooking()" class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ═════════════════════════════════════════ --}}
        {{-- CALENDRIER (3 colonnes) --}}
        {{-- ═════════════════════════════════════════ --}}
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            {{-- Header calendrier --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-primary capitalize">
                    {{ $dateReference->locale('fr')->translatedFormat('F Y') }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('client.rendez-vous.create', ['mois' => $moisPrecedent]) }}"
                       class="w-10 h-10 border border-gray-200 hover:border-primary rounded-lg flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <a href="{{ route('client.rendez-vous.create', ['mois' => $moisSuivant]) }}"
                       class="w-10 h-10 border border-gray-200 hover:border-primary rounded-lg flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Jours de la semaine --}}
            <div class="grid grid-cols-7 gap-2 mb-2">
                @foreach(['LUN', 'MAR', 'MER', 'JEU', 'VEN', 'SAM', 'DIM'] as $jour)
                    <div class="text-center text-xs font-semibold text-gray-400 py-2">{{ $jour }}</div>
                @endforeach
            </div>

            {{-- Jours du mois --}}
            <div class="grid grid-cols-7 gap-2">
                @foreach($calendrier as $jour)
                    @php
                        // Styles selon le statut
                        $classes = match(true) {
                            !$jour['is_mois_courant'] => 'text-gray-300',
                            $jour['statut'] === 'indisponible' => 'text-gray-300 cursor-not-allowed',
                            $jour['statut'] === 'complet' => 'bg-red-100 text-red-500 cursor-not-allowed',
                            $jour['statut'] === 'charge' => 'bg-orange-100 text-orange-700 hover:bg-orange-200 cursor-pointer',
                            $jour['statut'] === 'disponible' => 'bg-green-100 text-green-700 hover:bg-green-200 cursor-pointer',
                            default => 'text-gray-400',
                        };

                        $isClickable = $jour['is_mois_courant'] && in_array($jour['statut'], ['disponible', 'charge']);
                    @endphp

                    @if($isClickable)
                        <button type="button"
                                @click='selectDate("{{ $jour["date"] }}", @json($jour["heures_disponibles"]))'
                                :class="selectedDate === '{{ $jour['date'] }}' ? 'ring-2 ring-accent ring-offset-2' : ''"
                                class="relative text-center py-3 rounded-lg font-semibold text-sm transition-all {{ $classes }} {{ $jour['is_aujourdhui'] ? 'ring-2 ring-primary' : '' }}">
                            {{ $jour['jour'] }}
                            @if($jour['nb_rdv'] > 0)
                                <span class="absolute top-0.5 right-0.5 text-[9px] bg-white/60 rounded px-1">{{ $jour['nb_rdv'] }}</span>
                            @endif
                        </button>
                    @else
                        <div class="text-center py-3 rounded-lg font-semibold text-sm {{ $classes }} {{ $jour['is_aujourdhui'] ? 'ring-2 ring-primary' : '' }}">
                            {{ $jour['jour'] }}
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Légende --}}
            <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap gap-4 text-xs">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-green-100 border border-green-300 rounded"></div>
                    <span class="text-gray-600">Disponible</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-orange-100 border border-orange-300 rounded"></div>
                    <span class="text-gray-600">Chargé</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-red-100 border border-red-300 rounded"></div>
                    <span class="text-gray-600">Complet</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 border-2 border-primary rounded"></div>
                    <span class="text-gray-600">Aujourd'hui</span>
                </div>
            </div>
        </div>

        {{-- ═════════════════════════════════════════ --}}
        {{-- FORMULAIRE (2 colonnes) --}}
        {{-- ═════════════════════════════════════════ --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">

                <h2 class="text-lg font-bold text-primary mb-4">Réserver un créneau</h2>

                {{-- Aucune date sélectionnée --}}
                <div x-show="!selectedDate" class="text-center py-8">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">
                        👈 Cliquez sur une date disponible dans le calendrier
                    </p>
                </div>

                {{-- Formulaire (visible après sélection date) --}}
                <form x-show="selectedDate"
                      x-transition
                      action="{{ route('client.rendez-vous.store') }}"
                      method="POST"
                      class="space-y-4"
                      style="display: none;">
                    @csrf

                    {{-- Date sélectionnée --}}
                    <div class="bg-accent/10 border border-accent/20 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Date choisie</p>
                        <p class="font-bold text-primary mt-1" x-text="formatDate(selectedDate)"></p>
                        <input type="hidden" name="date" :value="selectedDate">
                    </div>

                    {{-- Créneaux horaires disponibles --}}
                    <div>
                        <label class="block text-sm font-semibold text-primary mb-2">
                            Choisissez un créneau <span class="text-red-500">*</span>
                        </label>

                        <div x-show="availableHours.length === 0" class="text-sm text-red-500 bg-red-50 rounded p-3">
                            Aucun créneau disponible ce jour. Choisissez une autre date.
                        </div>

                        <div x-show="availableHours.length > 0" class="grid grid-cols-3 gap-2">
                            <template x-for="hour in availableHours" :key="hour">
                                <button type="button"
                                        @click="selectedHour = hour"
                                        :class="selectedHour === hour ? 'bg-accent text-white border-accent' : 'bg-white text-primary border-gray-200 hover:border-accent'"
                                        class="border-2 rounded-lg py-2 text-sm font-semibold transition-all"
                                        x-text="hour">
                                </button>
                            </template>
                        </div>

                        <input type="hidden" name="heure" :value="selectedHour">
                        @error('heure')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type d'intervention --}}
                    <div>
                        <label class="block text-sm font-semibold text-primary mb-2">
                            Type d'intervention <span class="text-red-500">*</span>
                        </label>
                        <select name="type_intervention" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none text-sm">
                            <option value="">Choisir...</option>
                            @foreach(['Vidange', 'Révision', 'Diagnostic', 'Réparation freinage', 'Climatisation', 'Électricité', 'Tôlerie', 'Peinture', 'Autre'] as $type)
                                <option value="{{ $type }}" {{ old('type_intervention') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type_intervention')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-primary mb-2">Description (facultatif)</label>
                        <textarea name="description" rows="3" placeholder="Décrivez brièvement..."
                                  class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none text-sm">{{ old('description') }}</textarea>
                    </div>

                    {{-- Boutons --}}
                    <div class="flex gap-2 pt-2">
                        <button type="button"
                                @click="resetSelection()"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 font-semibold text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                                :disabled="!selectedHour"
                                :class="!selectedHour ? 'opacity-50 cursor-not-allowed' : ''"
                                class="flex-1 bg-accent hover:bg-accent-600 text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-lg shadow-accent/20">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script Alpine.js pour la logique --}}
<script>
    function rdvBooking() {
        return {
            selectedDate: null,
            selectedHour: null,
            availableHours: [],

            selectDate(date, hours) {
                this.selectedDate = date;
                this.availableHours = hours;
                this.selectedHour = null;
            },

            resetSelection() {
                this.selectedDate = null;
                this.selectedHour = null;
                this.availableHours = [];
            },

            formatDate(dateStr) {
                const date = new Date(dateStr);
                const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                return date.toLocaleDateString('fr-FR', options);
            }
        }
    }
</script>
@endsection