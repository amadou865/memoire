<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">Mes Devis</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase">
                        <tr>
                            <th class="px-6 py-4">N° Devis</th>
                            <th class="px-6 py-4">Véhicule</th>
                            <th class="px-6 py-4">Montant Total</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($devis as $d)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-primary">{{ $d->numero }}</td>
                                <td class="px-6 py-4">
                                    {{ $d->intervention->vehicule->immatriculation }}
                                    <span class="block text-xs text-gray-400">{{ $d->intervention->vehicule->marque }}</span>
                                </td>
                                <td class="px-6 py-4 font-bold text-accent">
                                    {{ number_format($d->montant_total, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badges = [
                                            'envoye'  => 'bg-amber-100 text-amber-800',
                                            'valide'  => 'bg-green-100 text-green-800',
                                            'refuse'  => 'bg-red-100 text-red-800',
                                            'facture' => 'bg-purple-100 text-purple-800',
                                        ];
                                        $labels = [
                                            'envoye'  => 'En attente de votre accord',
                                            'valide'  => 'Accepté',
                                            'refuse'  => 'Refusé',
                                            'facture' => 'Facturé',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badges[$d->statut] ?? 'bg-gray-100' }}">
                                        {{ $labels[$d->statut] ?? $d->statut }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('client.devis.show', $d) }}"
                                       class="px-4 py-2 bg-primary hover:bg-primary-light text-white text-xs font-semibold rounded-lg transition">
                                        {{ $d->statut === 'envoye' ? 'Examiner / Répondre' : 'Consulter' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    Aucun devis pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($devis->hasPages())
                    <div class="p-4 border-t border-gray-100">{{ $devis->links() }}</div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>