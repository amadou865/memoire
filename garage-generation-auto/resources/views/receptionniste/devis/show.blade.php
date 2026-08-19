@extends('layouts.authenticated')

@section('title', 'Détail devis')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.devis.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <div class="flex justify-between items-start mt-2">
            <div>
                <h1 class="text-3xl font-bold text-primary">{{ $devi->numero }}</h1>
                <p class="text-gray-500 mt-1">Créé le {{ $devi->date_creation->format('d/m/Y') }}</p>
            </div>
            <x-statut-badge :statut="$devi->statut" />
        </div>
    </div>

    {{-- Info client + intervention --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">👤 Client</h2>
            <p class="font-bold text-primary">{{ $devi->intervention->vehicule->client->prenom }} {{ $devi->intervention->vehicule->client->nom }}</p>
            <p class="text-sm text-gray-500 mt-1">📞 {{ $devi->intervention->vehicule->client->telephone }}</p>
            <p class="text-sm text-gray-500">📧 {{ $devi->intervention->vehicule->client->email }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">🚗 Véhicule</h2>
            <p class="font-bold text-primary">{{ $devi->intervention->vehicule->marque }} {{ $devi->intervention->vehicule->modele }}</p>
            <p class="text-sm text-gray-500 mt-1 font-mono">{{ $devi->intervention->vehicule->immatriculation }}</p>
            <p class="text-sm text-gray-500">Année {{ $devi->intervention->vehicule->annee }}</p>
        </div>
    </div>

    {{-- Détail devis --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
        <h2 class="text-lg font-bold text-primary mb-6">💰 Détail du devis</h2>

        <div class="space-y-4">
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <span class="text-gray-600">Main d'œuvre</span>
                <span class="font-semibold text-primary">{{ number_format($devi->montant_mo, 0, ',', ' ') }} F CFA</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <span class="text-gray-600">Pièces détachées</span>
                <span class="font-semibold text-primary">{{ number_format($devi->montant_pieces, 0, ',', ' ') }} F CFA</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <span class="text-gray-600">Diagnostic électronique</span>
                <span class="font-semibold text-primary">{{ number_format($devi->montant_valise, 0, ',', ' ') }} F CFA</span>
            </div>
            <div class="flex justify-between bg-accent/10 -mx-8 px-8 py-4 mt-4">
                <span class="font-bold text-primary text-lg">TOTAL TTC</span>
                <span class="font-bold text-accent text-2xl">{{ number_format($devi->montant_total, 0, ',', ' ') }} F CFA</span>
            </div>
        </div>

        {{-- Pièces détaillées --}}
        @if($devi->intervention->lignesPieces->isNotEmpty())
            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="text-sm font-bold text-primary mb-3">🔩 Détail des pièces</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-2 text-xs font-semibold text-gray-500 uppercase">Pièce</th>
                            <th class="text-center py-2 text-xs font-semibold text-gray-500 uppercase">Qté</th>
                            <th class="text-right py-2 text-xs font-semibold text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($devi->intervention->lignesPieces as $lp)
                            <tr>
                                <td class="py-2">{{ $lp->piece->designation }}</td>
                                <td class="py-2 text-center">{{ $lp->quantite_utilisee }}</td>
                                <td class="py-2 text-right font-semibold">{{ number_format($lp->quantite_utilisee * $lp->prix_unitaire_applique, 0, ',', ' ') }} F</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Actions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-primary mb-4">⚡ Actions</h2>
        <div class="flex flex-wrap gap-3">

            @if($devi->statut === 'brouillon')
                <form action="{{ route('receptionniste.devis.valider', $devi) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                        ✓ Valider le devis
                    </button>
                </form>
                <a href="{{ route('receptionniste.devis.edit', $devi) }}" class="bg-primary hover:bg-primary-light text-white font-semibold px-4 py-2 rounded-lg text-sm">
                    ✏️ Modifier
                </a>
            @endif

            @if($devi->statut === 'valide' && !$devi->facture)
                <form action="{{ route('receptionniste.factures.generer', $devi) }}" method="POST" class="inline">
                    @csrf
                    <button class="bg-accent hover:bg-accent-600 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                        📄 Générer la facture
                    </button>
                </form>
            @endif

            @if($devi->facture)
                <a href="{{ route('receptionniste.factures.show', $devi->facture) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                    📄 Voir la facture ({{ $devi->facture->numero }})
                </a>
            @endif

            @if($devi->statut !== 'facture')
                <form action="{{ route('receptionniste.devis.destroy', $devi) }}" method="POST" onsubmit="return confirm('Supprimer ce devis ?')" class="inline">
                    @csrf @method('DELETE')
                    <button class="border border-red-200 text-red-500 hover:bg-red-50 font-semibold px-4 py-2 rounded-lg text-sm">🗑️ Supprimer</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection