@extends('layouts.authenticated')

@section('title', 'Clients')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Clients</h1>
            <p class="text-gray-500 mt-1">{{ $clients->total() }} client(s) au total</p>
        </div>
        <a href="{{ route('receptionniste.clients.create') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg shadow-accent/20">
            + Nouveau client
        </a>
    </div>

    {{-- Barre de recherche --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('receptionniste.clients.index') }}" class="flex gap-2">
            <div class="flex-1 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Rechercher par nom, prénom, email, téléphone..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent outline-none">
            </div>
            <button type="submit" class="bg-primary hover:bg-primary-light text-white font-semibold px-6 py-2.5 rounded-lg">
                Rechercher
            </button>
            @if($search)
                <a href="{{ route('receptionniste.clients.index') }}" class="border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold px-4 py-2.5 rounded-lg">
                    ✕
                </a>
            @endif
        </form>
    </div>

    {{-- Liste --}}
    @if($clients->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">Aucun client trouvé</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Client</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Contact</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Véhicules</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Inscrit le</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($clients as $client)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-sm">
                                        {{ strtoupper(substr($client->prenom, 0, 1)) }}{{ strtoupper(substr($client->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-primary">{{ $client->prenom }} {{ $client->nom }}</p>
                                        <p class="text-xs text-gray-500">ID #{{ $client->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600">{{ $client->email }}</p>
                                <p class="text-xs text-gray-500">{{ $client->telephone ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-semibold">
                                    {{ $client->vehicules_count }} véhicule(s)
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $client->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('receptionniste.clients.show', $client) }}" class="text-primary hover:text-accent font-semibold text-sm mr-3">Voir</a>
                                <a href="{{ route('receptionniste.clients.edit', $client) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm mr-3">Modifier</a>
                                <form action="{{ route('receptionniste.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Supprimer ce client ?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $clients->links() }}</div>
    @endif
</div>
@endsection