@extends('layouts.authenticated')

@section('title', 'Espace Chef de Département')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-primary">Espace Chef de Département</h1>
                <p class="text-gray-500">{{ auth()->user()->prenom }} {{ auth()->user()->nom }} - Département : <span class="font-semibold text-accent">{{ auth()->user()->departement }}</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
            <div class="bg-blue-50 rounded-xl p-6">
                <p class="text-blue-600 text-sm font-semibold">Interventions</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-green-50 rounded-xl p-6">
                <p class="text-green-600 text-sm font-semibold">Diagnostics</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-orange-50 rounded-xl p-6">
                <p class="text-orange-600 text-sm font-semibold">Pièces utilisées</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-6">
                <p class="text-purple-600 text-sm font-semibold">Stock</p>
                <p class="text-3xl font-bold text-primary mt-2">0</p>
            </div>
        </div>
    </div>
</div>
@endsection