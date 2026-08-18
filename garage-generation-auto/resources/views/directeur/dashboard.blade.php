@extends('layouts.authenticated')

@section('title', 'Espace Directeur Technique')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-primary">Espace Directeur Technique</h1>
                <p class="text-gray-500">{{ auth()->user()->prenom }} {{ auth()->user()->nom }} - {{ auth()->user()->grade }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
            <div class="bg-blue-50 rounded-xl p-6">
                <p class="text-blue-600 text-sm font-semibold">À valider</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-green-50 rounded-xl p-6">
                <p class="text-green-600 text-sm font-semibold">Validées</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-red-50 rounded-xl p-6">
                <p class="text-red-600 text-sm font-semibold">Retours atelier</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-6">
                <p class="text-purple-600 text-sm font-semibold">Total essais</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
        </div>
    </div>
</div>
@endsection