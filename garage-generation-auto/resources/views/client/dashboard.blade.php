@extends('layouts.authenticated')

@section('title', 'Espace Client')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-primary">Bienvenue {{ auth()->user()->prenom }} !</h1>
                <p class="text-gray-500">Espace Client - Génération Automobile</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
            <div class="bg-blue-50 rounded-xl p-6">
                <p class="text-blue-600 text-sm font-semibold">Véhicules</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-green-50 rounded-xl p-6">
                <p class="text-green-600 text-sm font-semibold">RDV à venir</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-orange-50 rounded-xl p-6">
                <p class="text-orange-600 text-sm font-semibold">Interventions</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-6">
                <p class="text-purple-600 text-sm font-semibold">Factures</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
        </div>
    </div>
</div>
@endsection