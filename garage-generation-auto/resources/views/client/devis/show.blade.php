<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-primary leading-tight">
                Devis n° {{ $devi->numero }}
            </h2>
            <a href="{{ route('client.devis.index') }}" class="text-sm text-gray-500 hover:text-primary">
                ← Retour à mes devis
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Carte d'action Client si Devis "envoye" --}}
            @if($devi->statut === 'envoye')
                <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">📋</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-amber-900">Validation requise</h3>
                            <p class="text-sm text-amber-700 mt-1">
                                Veuillez examiner les détails du devis ci-dessous et faire votre choix. 
                                Les travaux ou la facturation ne commenceront qu'après votre accord.
                            </p>

                            <div class="mt-6 flex flex-wrap gap-4" x-data="{ showRefusModal: false }">
                                {{-- Bouton Valider --}}
                                <form method="POST" action="{{ route('client.devis.valider', $devi) }}"
                                      onsubmit="return confirm('Confirmez-vous l\'acceptation de ce devis d\'un montant de {{ number_format($devi->montant_total, 0, ',', ' ') }} FCFA ?')">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg shadow-green-600/20 transition flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Accepter le devis
                                    </button>
                                </form>

                                {{-- Bouton Refuser --}}
                                <button @click="showRefusModal = true" type="button"
                                        class="px-6 py-3 bg-red-100 hover:bg-red-200 text-red-700 font-bold rounded-xl transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Refuser le devis
                                </button>

                                {{-- Modal Motif de Refus --}}
                                <div x-show="showRefusModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
                                    <div @click.outside="showRefusModal = false" class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4">
                                        <h4 class="text-lg font-bold text-gray-900">Motif du refus</h4>
                                        <p class="text-sm text-gray-500">Veuillez nous indiquer pourquoi vous refusez ce devis :</p>
                                        
                                        <form method="POST" action="{{ route('client.devis.refuser', $devi) }}">
                                            @csrf @method('PATCH')
                                            <textarea name="motif_refus" rows="3" required
                                                      placeholder="Ex : Tarif élevé, travail reporté..."
                                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm mb-4"></textarea>
                                            
                                            <div class="flex justify-end gap-3">
                                                <button @click="showRefusModal = false" type="button" class="px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 rounded-lg">Annuler</button>
                                                <button type="submit" class="px-4 py-2 text-sm bg-red-600 text-white font-bold rounded-lg hover:bg-red-700">Confirmer le refus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($devi->statut === 'valide')
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <div>
                        <p class="font-bold">Devis accepté le {{ $devi->date_validation ? $devi->date_validation->format('d/m/Y à H:i') : '' }}</p>
                        <p class="text-sm text-green-700">Merci pour votre confiance. La facture finale sera bientôt disponible.</p>
                    </div>
                </div>
            @elseif($devi->statut === 'refuse')
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex items-center gap-3">
                    <span class="text-2xl">❌</span>
                    <div>
                        <p class="font-bold">Devis refusé</p>
                        <p class="text-sm text-red-700">Motif : {{ $devi->motif_refus }}</p>
                    </div>
                </div>
            @endif

            {{-- Fiche détaillée du Devis --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-primary">GÉNÉRATION AUTOMOBILE</h1>
                        <p class="text-sm text-gray-500">Cambérène, Dakar, Sénégal</p>
                        <p class="text-sm text-gray-500">Tél : +221 77 123 45 67</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase mb-2
                            {{ $devi->statut === 'valide' ? 'bg-green-100 text-green-700' : ($devi->statut === 'refuse' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            Devis {{ $devi->statut }}
                        </span>
                        <p class="text-sm font-semibold text-gray-700">Date : {{ $devi->date_creation->format('d/m/Y') }}</p>
                    </div>
                </div>

                {{-- Informations Véhicule & Nature --}}
                <div class="p-8 bg-gray-50/50 grid grid-cols-2 gap-6 text-sm border-b border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Véhicule concerné</p>
                        <p class="font-bold text-primary text-base mt-1">{{ $devi->intervention->vehicule->immatriculation }}</p>
                        <p class="text-gray-600">{{ $devi->intervention->vehicule->marque }} {{ $devi->intervention->vehicule->modele }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Nature des travaux</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $devi->intervention->nature }}</p>
                        <p class="text-gray-500">Département : {{ ucfirst($devi->intervention->departement) }}</p>
                    </div>
                </div>

                {{-- Table des Montants --}}
                <div class="p-8">
                    <table class="w-full text-left text-sm mb-6">
                        <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase">
                            <tr>
                                <th class="p-3">Désignation</th>
                                <th class="p-3 text-right">Montant FCFA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="p-3 font-medium text-gray-800">Main-d'œuvre (MO)</td>
                                <td class="p-3 text-right font-semibold">{{ number_format($devi->montant_mo, 0, ',', ' ') }} F</td>
                            </tr>
                            @if($devi->montant_pieces > 0)
                                <tr>
                                    <td class="p-3 font-medium text-gray-800">Pièces détachées & Fournitures</td>
                                    <td class="p-3 text-right font-semibold">{{ number_format($devi->montant_pieces, 0, ',', ' ') }} F</td>
                                </tr>
                            @endif
                            @if($devi->montant_valise > 0)
                                <tr>
                                    <td class="p-3 font-medium text-gray-800">Diagnostic électronique (Valise)</td>
                                    <td class="p-3 text-right font-semibold">{{ number_format($devi->montant_valise, 0, ',', ' ') }} F</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="border-t-2 border-gray-200 pt-4 flex justify-between items-center">
                        <span class="text-lg font-bold text-primary">TOTAL DU DEVIS :</span>
                        <span class="text-2xl font-extrabold text-accent">{{ number_format($devi->montant_total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>