@extends('layouts.authenticated')

@section('title', 'Gestion Utilisateurs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary">Gestion des Utilisateurs</h1>
            <p class="text-gray-500 mt-1">{{ $users->total() }} utilisateur(s)</p>
        </div>
        <a href="{{ route('admin.utilisateurs.create') }}" class="bg-accent hover:bg-accent-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg">
            + Nouvel Utilisateur
        </a>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-center">
            <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom, email, matricule..."
                   class="flex-1 min-w-[200px] px-4 py-2 border border-gray-200 rounded-lg">
            <select name="role" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-4 py-2 text-sm">
                <option value="">Tous les rôles</option>
                <option value="client" {{ $role === 'client' ? 'selected' : '' }}>Client</option>
                <option value="receptionniste" {{ $role === 'receptionniste' ? 'selected' : '' }}>Réceptionniste</option>
                <option value="chef_departement" {{ $role === 'chef_departement' ? 'selected' : '' }}>Chef Département</option>
                <option value="directeur_technique" {{ $role === 'directeur_technique' ? 'selected' : '' }}>Directeur Technique</option>
                <option value="administrateur" {{ $role === 'administrateur' ? 'selected' : '' }}>Administrateur</option>
            </select>
            <button type="submit" class="bg-primary hover:bg-primary-light text-white font-semibold px-5 py-2 rounded-lg">Filtrer</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Utilisateur</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Rôle</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Matricule / Dépt</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Contact</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $u)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-primary text-sm">
                            {{ $u->prenom }} {{ $u->nom }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badge = match($u->role) {
                                    'administrateur' => 'bg-purple-100 text-purple-800',
                                    'directeur_technique' => 'bg-blue-100 text-blue-800',
                                    'chef_departement' => 'bg-orange-100 text-orange-800',
                                    'receptionniste' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $badge }}">
                                {{ ucfirst(str_replace('_', ' ', $u->role)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $u->matricule ?? '—' }} {{ $u->departement ? "({$u->departement})" : '' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $u->email }} <br><span class="text-xs text-gray-400">{{ $u->telephone }}</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.utilisateurs.edit', $u) }}" class="text-primary hover:text-accent font-semibold text-sm">Modifier</a>
                            @if($u->id !== auth()->id())
                                <form action="{{ route('admin.utilisateurs.destroy', $u) }}" method="POST" onsubmit="return confirm('Supprimer ?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 text-sm font-semibold">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection