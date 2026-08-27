<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-primary leading-tight">
                    Devis n° {{ $devi->numero }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Créé le {{ $devi->date_creation->format('d/m/Y') }}
                    · Intervention #{{ $devi->intervention_id }}
                </p>
            </div>

            {{-- ═══════════ BOUTONS D'ACTION ═══════════ --}}
            <div class="flex flex-wrap items-center gap-3">

                @if($devi->statut === 'brouillon')
                    <form method="POST" action="{{ route('receptionniste.devis.envoyer', $devi) }}"
                          onsubmit="return confirm('Envoyer ce devis au client pour validation ?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-accent hover:bg-orange-600 text-white font-bold rounded-lg text-sm shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Envoyer au client pour validation
                        </button>
                    </form>

                @elseif($devi->statut === 'envoye')
                    <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-100 text-amber-800 rounded-lg text-sm font-bold border border-amber-200">
                        <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        En attente de la réponse du client
                    </span>

                @elseif($devi->statut === 'valide' && !$devi->facture)
                    <form method="POST" action="{{ route('receptionniste.factures.generer', $devi) }}"
                          onsubmit="return confirm('Générer la facture finale pour ce devis validé ?')">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg text-sm shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                            </svg>
                            Générer la facture finale
                        </button>
                    </form>

                @elseif($devi->statut === 'refuse')
                    <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-100 text-red-800 rounded-lg text-sm font-bold border border-red-200 max-w-xs">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Refusé : {{ $devi->motif_refus ?? 'Sans motif' }}
                    </span>

                @elseif($devi->statut === 'facture')
                    <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-100 text-purple-800 rounded-lg text-sm font-bold border border-purple-200">
                        ✅ Facturé
                        @if($devi->facture)
                            <a href="{{ route('receptionniste.factures.show', $devi->facture) }}"
                               class="underline hover:no-underline ml-1">
                                Voir facture →
                            </a>
                        @endif
                    </span>
                @endif

                <a href="{{ route('receptionniste.devis.index') }}"
                   class="px-4 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                    ← Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Messages flash --}}
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Badge statut --}}
            @php
                $statutStyles = [
                    'brouillon' => 'bg-gray-100 text-gray-700',
                    'envoye'    => 'bg-amber-100 text-amber-800',
                    'valide'    => 'bg-green-100 text-green-800',
                    'refuse'    => 'bg-red-100 text-red-800',
                    'facture'   => 'bg-purple-100 text-purple-800',
                    'annule'    => 'bg-gray-200 text-gray-500',
                ];
                $statutLabels = [
                    'brouillon' => 'Brouillon',
                    'envoye'    => 'Envoyé au client',
                    'valide'    => 'Validé par le client',
                    'refuse'    => 'Refusé par le client',
                    'facture'   => 'Facturé',
                    'annule'    => 'Annulé',
                ];
            @endphp

            {{-- Carte principale du devis --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- En-tête garage --}}
                <div class="p-8 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-extrabold text-primary tracking-tight">GÉNÉRATION AUTOMOBILE</h1>
                        <p class="text-sm text-gray-500 mt-1">Cambérène, Dakar — Sénégal</p>
                        <p class="text-sm text-gray-500">Tél : +221 77 123 45 67 · contact@generation-auto.sn</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase mb-2 {{ $statutStyles[$devi->statut] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $statutLabels[$devi->statut] ?? $devi->statut }}
                        </span>
                        <p class="text-sm font-semibold text-gray-700">Devis n° {{ $devi->numero }}</p>
                        <p class="text-sm text-gray-500">Date : {{ $devi->date_creation->format('d/m/Y') }}</p>
                        @if($devi->date_validation)
                            <p class="text-xs text-gray-400 mt-1">
                                Réponse client : {{ $devi->date_validation->format('d/m/Y à H:i') }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Client & Véhicule --}}
                <div class="p-8 bg-gray-50/60 grid grid-cols-1 sm:grid-cols-2 gap-6 border-b border-gray-100 text-sm">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Client</p>
                        @php $client = $devi->intervention->vehicule->client; @endphp
                        <p class="font-bold text-primary text-base">{{ $client->prenom }} {{ $client->nom }}</p>
                        <p class="text-gray-600">{{ $client->telephone }}</p>
                        <p class="text-gray-500">{{ $client->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Véhicule & travaux</p>
                        @php $vehicule = $devi->intervention->vehicule; @endphp
                        <p class="font-bold text-primary text-base">{{ $vehicule->immatriculation }}</p>
                        <p class="text-gray-600">{{ $vehicule->marque }} {{ $vehicule->modele }}
                            @if($vehicule->annee) ({{ $vehicule->annee }}) @endif
                        </p>
                        <p class="text-gray-500 mt-1">
                            Nature : <span class="font-medium text-gray-700">{{ $devi->intervention->nature }}</span>
                        </p>
                        <p class="text-gray-500">
                            Département : <span class="font-medium text-gray-700">{{ ucfirst($devi->intervention->departement) }}</span>
                        </p>
                    </div>
                </div>

                {{-- Détail des montants --}}
                <div class="p-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Détail du devis</h3>

                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase">
                                <th class="text-left px-4 py-3 rounded-l-lg">Désignation</th>
                                <th class="text-right px-4 py-3 rounded-r-lg">Montant (FCFA)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-4 py-4 font-medium text-gray-800">Main-d'œuvre (MO)</td>
                                <td class="px-4 py-4 text-right font-semibold text-gray-800">
                                    {{ number_format($devi->montant_mo, 0, ',', ' ') }} F
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 font-medium text-gray-800">Pièces détachées & fournitures</td>
                                <td class="px-4 py-4 text-right font-semibold text-gray-800">
                                    {{ number_format($devi->montant_pieces, 0, ',', ' ') }} F
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 font-medium text-gray-800">Diagnostic électronique (valise)</td>
                                <td class="px-4 py-4 text-right font-semibold text-gray-800">
                                    {{ number_format($devi->montant_valise, 0, ',', ' ') }} F
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-primary/20">
                                <td class="px-4 py-5 text-lg font-extrabold text-primary">TOTAL DU DEVIS</td>
                                <td class="px-4 py-5 text-right text-2xl font-extrabold text-accent">
                                    {{ number_format($devi->montant_total, 0, ',', ' ') }}
                                    <span class="text-sm font-bold">FCFA</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Motif de refus si applicable --}}
                @if($devi->statut === 'refuse' && $devi->motif_refus)
                    <div class="mx-8 mb-8 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-xs font-bold text-red-500 uppercase mb-1">Motif du refus client</p>
                        <p class="text-sm text-red-800">{{ $devi->motif_refus }}</p>
                    </div>
                @endif
            </div>

            {{-- Rappel du workflow --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Cycle de validation</p>
                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                    @php
                        $etapes = [
                            'brouillon' => '1. Brouillon',
                            'envoye'    => '2. Envoyé au client',
                            'valide'    => '3. Validé',
                            'facture'   => '4. Facturé',
                        ];
                        $ordre = ['brouillon', 'envoye', 'valide', 'facture'];
                        $indexActuel = array_search($devi->statut === 'refuse' ? 'envoye' : $devi->statut, $ordre);
                    @endphp

                    @foreach($etapes as $key => $label)
                        @php
                            $i = array_search($key, $ordre);
                            $actif = $i <= $indexActuel && $devi->statut !== 'refuse';
                            $refuseIci = $devi->statut === 'refuse' && $key === 'envoye';
                        @endphp
                        <span class="px-3 py-1.5 rounded-full
                            {{ $refuseIci ? 'bg-red-100 text-red-700' : ($actif ? 'bg-primary text-white' : 'bg-gray-100 text-gray-400') }}">
                            {{ $label }}
                        </span>
                        @if(!$loop->last)
                            <span class="text-gray-300">→</span>
                        @endif
                    @endforeach

                    @if($devi->statut === 'refuse')
                        <span class="text-gray-300">→</span>
                        <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-700">Refusé</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>