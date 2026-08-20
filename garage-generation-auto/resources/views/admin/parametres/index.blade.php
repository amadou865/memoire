@extends('layouts.authenticated')

@section('title', 'Paramètres')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">⚙️ Paramètres du Garage</h1>
        <p class="text-gray-500 mt-1">Informations et configuration</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
        <div>
            <h2 class="text-xl font-bold text-primary mb-4">📍 Coordonnées de l'établissement</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs">Nom de l'entreprise</p>
                    <p class="font-bold text-primary mt-1">{{ $garageInfo['nom'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs">Adresse</p>
                    <p class="font-bold text-primary mt-1">{{ $garageInfo['adresse'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs">Téléphone</p>
                    <p class="font-bold text-primary mt-1">{{ $garageInfo['telephone'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs">Email</p>
                    <p class="font-bold text-primary mt-1">{{ $garageInfo['email'] }}</p>
                </div>
            </div>
        </div>

        <div class="border-t pt-6">
            <h2 class="text-xl font-bold text-primary mb-4">🛠️ Départements actifs</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($garageInfo['departements'] as $d)
                    <span class="bg-accent/10 text-accent font-semibold px-4 py-2 rounded-xl text-sm border border-accent/20">
                        {{ $d }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection