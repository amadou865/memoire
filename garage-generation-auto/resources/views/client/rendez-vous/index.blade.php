@extends('layouts.authenticated')

@section('title', 'Mes rendez-vous')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Mes rendez-vous</h1>
            <p class="text-gray-500 mt-1">{{ $rendezVous->count() }} rendez-vous</p>
        </div>
        <a href="{{ route('client.rendez-vous.create') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20">
            + Nouveau rendez-vous
        </a>
    </div>

    @if($rendezVous->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500 mb-4">Vous n'avez aucun rendez-vous</p>
            <a href="{{ route('client.rendez-vous.create') }}" class="text-accent font-semibold hover:underline">
                Prendre mon premier rendez-vous →
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Heure</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rendezVous as $rdv)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-primary">
                                {{ \Carbon\Carbon::parse($rdv->date)->locale('fr')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($rdv->heure)->format('H\hi') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $rdv->type_intervention }}</td>
                            <td class="px-6 py-4"><x-statut-badge :statut="$rdv->statut" /></td>
                            <td class="px-6 py-4 text-right">
                                @if($rdv->statut !== 'annule')
                                    <form action="{{ route('client.rendez-vous.destroy', $rdv) }}" method="POST" onsubmit="return confirm('Annuler ce rendez-vous ?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Annuler</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection