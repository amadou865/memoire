@extends('layouts.authenticated')

@section('title', 'Facture ' . $facture->numero)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <a href="{{ route('receptionniste.factures.index') }}" class="text-gray-500 hover:text-primary text-sm">← Retour</a>
        <div class="flex justify-between items-start mt-2">
            <div>
                <h1 class="text-3xl font-bold text-primary">{{ $facture->numero }}</h1>
                <p class="text-gray-500 mt-1">Émise le {{ $facture->date_emission->format('d/m/Y') }}</p>
            </div>
            <x-statut-badge :statut="$facture->statut" />
        </div>
    </div>

    {{-- Facture (aperçu style facture) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">

        {{-- Header facture --}}
        <div class="flex justify-between items-start pb-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-primary">Génération <span class="text-accent">Automobile</span></h2>
                <p class="text-sm text-gray-500 mt-1">Cambérène, Dakar, Sénégal</p>
                <p class="text-sm text-gray-500">📞 +221 77 123 45 67</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 uppercase">Facture</p>
                <p class="text-xl font-bold text-primary">{{ $facture->numero }}</p>
                <p class="text-sm text-gray-500 mt-1">Date : {{ $facture->date_emission->format('d/m/Y') }}</p>
            </div>
        </div>

        {{-- Client --}}
        <div class="my-6">
            <p class="text-xs text-gray-500 uppercase font-semibold">Facturé à</p>
            <p class="font-bold text-primary text-lg mt-1">{{ $facture->devis->intervention->vehicule->client->prenom }} {{ $facture->devis->intervention->vehicule->client->nom }}</p>
            <p class="text-sm text-gray-600">{{ $facture->devis->intervention->vehicule->client->email }}</p>
            <p class="text-sm text-gray-600">{{ $facture->devis->intervention->vehicule->client->telephone }}</p>
        </div>

        {{-- Véhicule --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <p class="text-xs text-gray-500 uppercase font-semibold">Véhicule concerné</p>
            <p class="text-primary font-semibold mt-1">
                {{ $facture->devis->intervention->vehicule->marque }} {{ $facture->devis->intervention->vehicule->modele }}
                • <span class="font-mono">{{ $facture->devis->intervention->vehicule->immatriculation }}</span>
            </p>
            <p class="text-sm text-gray-500 mt-1">Intervention : {{ $facture->devis->intervention->nature }}</p>
        </div>

        {{-- Détails --}}
        <table class="w-full mb-6">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 text-xs font-semibold text-gray-500 uppercase">Désignation</th>
                    <th class="text-right py-3 text-xs font-semibold text-gray-500 uppercase">Montant</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr>
                    <td class="py-3">Main d'œuvre</td>
                    <td class="py-3 text-right font-semibold">{{ number_format($facture->devis->montant_mo, 0, ',', ' ') }} F CFA</td>
                </tr>
                <tr>
                    <td class="py-3">Pièces détachées</td>
                    <td class="py-3 text-right font-semibold">{{ number_format($facture->devis->montant_pieces, 0, ',', ' ') }} F CFA</td>
                </tr>
                <tr>
                    <td class="py-3">Diagnostic électronique</td>
                    <td class="py-3 text-right font-semibold">{{ number_format($facture->devis->montant_valise, 0, ',', ' ') }} F CFA</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-primary">
                    <td class="pt-4 font-bold text-primary text-lg">TOTAL TTC</td>
                    <td class="pt-4 text-right font-bold text-accent text-2xl">{{ number_format($facture->montant_total, 0, ',', ' ') }} F CFA</td>
                </tr>
            </tfoot>
        </table>

        {{-- Statut paiement --}}
        @if($facture->statut === 'paye')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-green-800">✓ Facture payée</p>
                    <p class="text-sm text-green-600">Mode : {{ ucfirst($facture->mode_payement) }}</p>
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="font-semibold text-yellow-800">⏳ En attente de paiement</p>
            </div>
        @endif
    </div>

    {{-- Actions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-primary mb-4">⚡ Actions</h2>

        @if($facture->statut === 'en_attente')
            <form action="{{ route('receptionniste.factures.paiement', $facture) }}" method="POST" class="flex gap-3">
                @csrf @method('PATCH')
                <select name="mode_payement" required class="flex-1 px-4 py-2 border border-gray-200 rounded-lg">
                    <option value="">Mode de paiement...</option>
                    <option value="espèces">💵 Espèces</option>
                    <option value="carte">💳 Carte bancaire</option>
                    <option value="virement">🏦 Virement</option>
                    <option value="chèque">📝 Chèque</option>
                    <option value="mobile_money">📱 Mobile Money</option>
                </select>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg text-sm">
                    ✓ Enregistrer le paiement
                </button>
            </form>
        @endif

        <div class="mt-4 flex gap-3">
            <button onclick="window.print()" class="bg-primary hover:bg-primary-light text-white font-semibold px-4 py-2 rounded-lg text-sm">
                🖨️ Imprimer
            </button>
            @if($facture->statut !== 'paye')
                <form action="{{ route('receptionniste.factures.destroy', $facture) }}" method="POST" onsubmit="return confirm('Supprimer cette facture ?')" class="inline">
                    @csrf @method('DELETE')
                    <button class="border border-red-200 text-red-500 hover:bg-red-50 font-semibold px-4 py-2 rounded-lg text-sm">🗑️ Supprimer</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection