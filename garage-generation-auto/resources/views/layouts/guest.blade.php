<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Génération Automobile') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">

            {{-- Logo Génération Automobile --}}
            <div class="mb-2">
                <a href="{{ route('accueil') }}" class="flex flex-col items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Génération Automobile"
                         class="h-20 w-auto object-contain">
                    <span class="text-primary font-bold text-xl tracking-tight">
                        Génération <span class="text-accent">Automobile</span>
                    </span>
                </a>
            </div>

            {{-- Carte du formulaire --}}
            <div class="w-full sm:max-w-md mt-4 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-2xl border border-gray-100">
                {{ $slot }}
            </div>

            {{-- Lien retour accueil --}}
            <p class="mt-6 text-sm text-gray-500">
                <a href="{{ route('accueil') }}" class="text-primary hover:text-accent font-medium transition">
                    ← Retour à l'accueil
                </a>
            </p>
        </div>
    </body>
</html>