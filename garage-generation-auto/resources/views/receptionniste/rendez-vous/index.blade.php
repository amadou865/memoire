@extends('layouts.authenticated')

@section('title', 'Rendez-vous')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Rendez-vous</h1>
            <p class="text-gray-500 mt-1">Gérez tous les rendez-vous</p>
        </div>
        <a href="{{ route('receptionniste.rendez-vous.create') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20">
            + Créer un RDV
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('receptionniste.rendez-vous.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-primary transition-all">
            <p class="text-gray-500 text-xs uppercase font-semibold">Total</p>
            <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total'] }}</p>
        </a>
        <a href="{{ route('receptionniste.rendez-vous.index', ['statut' => 'en_attente']) }}" class="bg-yellow-50 rounded-xl border border-yellow-200 p-4 hover:border-yellow-400 transition-all">
            <p class="text-yellow-700 text-xs uppercase font-semibold">En attente</p>
            <p class="text-2xl font-bold text-yellow-800 mt-1">{{ $stats['en_attente'] }}</p>
        </a>
        <a href="{{ route('receptionniste.rendez-vous.index', ['statut' => 'confirme']) }}" class="bg-green-50 rounded-xl border border-green-200 p-4 hover:border-green-400 transition-all">
            <p class="text-green-700 text-xs uppercase font-semibold">Confirmés</p>
            <p class="text-2xl font-bold text-green-800 mt-1">{{ $stats['confirme'] }}</p>
        </a>
        <a href="{{ route('receptionniste.rendez-vous.index', ['date' => today()->format('Y-m-d')]) }}" class="bg-blue-50 rounded-xl border border-blue-200 p-4 hover:border-blue-400 transition-all">
            <p class="text-blue-700 text-xs uppercase font-semibold">Aujourd'hui</p>
            <p class="text-2xl font-bold text-blue-800 mt-1">{{ $stats['aujourdhui'] }}</p>
        </a>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Statut</label>
                <select name="statut" onchange="this.form.submit()" class="mt-1 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Tous</option>
                    <option value="en_attente" {{ $statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="confirme" {{ $statut === 'confirme' ? 'selected' : '' }}>Confirmé</option>
                    <option value="annule" {{ $statut === 'annule' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase">Date</label>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="mt-1 border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>
            @if($statut || $date)
                <a href="{{ route('receptionniste.rendez-vous.index') }}" class="text-sm text-gray-500 hover:text-primary">✕ Réinitialiser</a>
            @endif
        </form>
    </div>

    {{-- Liste --}}
    @if($rendezVous->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucun rendez-vous trouvé</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date/Heure</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Client</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rendezVous as $rdv)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-primary">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rdv->heure)->format('H\hi') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-primary text-sm">{{ $rdv->client->prenom }} {{ $rdv->client->nom }}</p>
                                <p class="text-xs text-gray-500">{{ $rdv->client->telephone }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $rdv->type_intervention }}</td>
                            <td class="px-6 py-4"><x-statut-badge :statut="$rdv->statut" /></td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($rdv->statut === 'en_attente')
                                    <form action="{{ route('receptionniste.rendez-vous.valider', $rdv) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="text-green-600 hover:text-green-800 text-sm font-semibold">✓ Valider</button>
                                    </form>
                                    <form action="{{ route('receptionniste.rendez-vous.refuser', $rdv) }}" method="POST" onsubmit="return confirm('Refuser ce RDV ?')" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="text-red-500 hover:text-red-700 text-sm font-semibold">✕ Refuser</button>
                                    </form>
                                @endif
                                <a href="{{ route('receptionniste.rendez-vous.show', $rdv) }}" class="text-primary hover:text-accent text-sm font-semibold">Détails</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $rendezVous->links() }}</div>
    @endif
</div>
@endsection