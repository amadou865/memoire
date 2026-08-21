@extends('layouts.public')

@section('title', 'Accueil')

@section('content')

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- SECTION 1 : HERO --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <section class="bg-gray-50 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Colonne gauche : Texte --}}
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-primary leading-tight">
                        Votre véhicule mérite<br>
                        le <span class="text-accent">meilleur soin</span>
                    </h1>

                    <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                        Garage multiservice à Dakar, Cambérène. De la mécanique à la
                        peinture, nous prenons soin de votre véhicule avec expertise et
                        professionnalisme.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        {{-- Bouton principal → scroll vers créneaux --}}
                        <a href="#creneaux"
                           class="inline-flex items-center gap-2 bg-accent hover:bg-accent-600 text-white font-semibold px-6 py-3.5 rounded-lg transition-all duration-200 shadow-lg shadow-accent/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Prendre un rendez-vous
                        </a>

                        {{-- Bouton secondaire --}}
                        <a href="#contact"
                           class="inline-flex items-center gap-2 border-2 border-gray-200 hover:border-primary text-primary font-semibold px-6 py-3.5 rounded-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Nous contacter
                        </a>
                    </div>
                </div>

                {{-- Colonne droite : Carte stats --}}
                <div class="bg-primary rounded-2xl p-8 lg:p-10 shadow-2xl">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-primary-light/50 rounded-xl p-6">
                            <div class="text-4xl lg:text-5xl font-bold text-accent">2 847</div>
                            <div class="text-gray-300 mt-2 text-sm">Interventions réalisées</div>
                        </div>
                        <div class="bg-primary-light/50 rounded-xl p-6">
                            <div class="text-4xl lg:text-5xl font-bold text-accent">98%</div>
                            <div class="text-gray-300 mt-2 text-sm">Clients satisfaits</div>
                        </div>
                        <div class="bg-primary-light/50 rounded-xl p-6">
                            <div class="text-4xl lg:text-5xl font-bold text-accent">12</div>
                            <div class="text-gray-300 mt-2 text-sm">Techniciens experts</div>
                        </div>
                        <div class="bg-primary-light/50 rounded-xl p-6">
                            <div class="text-4xl lg:text-5xl font-bold text-accent">5</div>
                            <div class="text-gray-300 mt-2 text-sm">Départements</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- SECTION 2 : NOS SERVICES --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <section id="services" class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-12">
                <p class="text-accent font-bold text-sm tracking-wider uppercase mb-3">Nos services</p>
                <h2 class="text-3xl lg:text-4xl font-bold text-primary">
                    Une expertise complète pour votre véhicule
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-accent transition-all duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Mécanique</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Entretien, réparation moteur, embrayage, distribution et freinage.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-accent transition-all duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Électricité automobile</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Diagnostic électronique, câblage, alternateur et démarreur.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-accent transition-all duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Froid et climatisation</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Recharge, réparation du circuit et remplacement du compresseur.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-accent transition-all duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Tôlerie</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Débosselage, redressage de châssis et remplacement de panneaux.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-accent transition-all duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Peinture</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Peinture complète, retouches et vernis de protection.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- SECTION 3 : CRÉNEAUX DISPONIBLES (dynamiques + cliquables) --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <section id="creneaux" class="py-16 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-12">
                <p class="text-accent font-bold text-sm tracking-wider uppercase mb-3">Disponibilités</p>
                <h2 class="text-3xl lg:text-4xl font-bold text-primary">
                    Créneaux disponibles
                </h2>
                <p class="mt-3 text-gray-600">
                    Cliquez sur une date verte pour réserver.
                    @guest
                        <span class="text-accent font-medium">Connexion ou création de compte requise.</span>
                    @endguest
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-primary">
                        {{ \Carbon\Carbon::now()->locale('fr')->translatedFormat('F Y') }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        Lun–Ven 8h–18h · Sam 8h–13h · Dim. fermé
                    </p>
                </div>

                {{-- Jours de la semaine --}}
                <div class="grid grid-cols-7 gap-2 mb-2">
                    @foreach(['LUN', 'MAR', 'MER', 'JEU', 'VEN', 'SAM', 'DIM'] as $jour)
                        <div class="text-center text-xs font-semibold text-gray-400 py-2">{{ $jour }}</div>
                    @endforeach
                </div>

                {{-- Grille dynamique : 2 semaines à partir de lundi --}}
                <div class="grid grid-cols-7 gap-2">
                    @php
                        $today = \Carbon\Carbon::today();
                        $start = $today->copy()->startOfWeek(); // lundi
                        $heureDefaut = '09:00';
                    @endphp

                    @for($i = 0; $i < 14; $i++)
                        @php
                            $date = $start->copy()->addDays($i);
                            $isPast   = $date->lt($today);
                            $isSunday = $date->isSunday();
                            $isToday  = $date->isToday();
                            $disponible = !$isPast && !$isSunday;

                            // URL du formulaire RDV avec date pré-remplie
                            $rdvUrl = route('client.rendez-vous.create', [
                                'date'  => $date->format('Y-m-d'),
                                'heure' => $heureDefaut,
                            ]);

                            // Si non connecté → login, puis retour vers le RDV
                            $cible = auth()->check()
                                ? $rdvUrl
                                : route('login', ['redirect' => $rdvUrl]);
                        @endphp

                        @if($disponible)
                            <a href="{{ $cible }}"
                               title="Réserver le {{ $date->locale('fr')->isoFormat('dddd D MMMM') }}"
                               class="text-center py-3 rounded-lg font-semibold transition-all
                                      {{ $isToday
                                            ? 'bg-accent text-white hover:bg-accent-600'
                                            : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                {{ $date->format('d') }}
                            </a>
                        @else
                            <div class="text-center py-3 text-sm rounded-lg
                                {{ $isSunday ? 'text-red-300 bg-red-50' : 'text-gray-400' }}">
                                {{ $date->format('d') }}
                            </div>
                        @endif
                    @endfor
                </div>

                {{-- Légende --}}
                <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-accent rounded"></div>
                        <span class="text-gray-600">Aujourd'hui</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-100 rounded"></div>
                        <span class="text-gray-600">Disponible — cliquable</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gray-100 rounded"></div>
                        <span class="text-gray-600">Passé / indisponible</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-red-50 border border-red-100 rounded"></div>
                        <span class="text-gray-600">Dimanche — fermé</span>
                    </div>
                </div>

                {{-- Message pour visiteurs non connectés --}}
                @guest
                    <div class="mt-6 p-4 bg-primary/5 border border-primary/10 rounded-xl text-center">
                        <p class="text-sm text-gray-700 mb-3">
                            Pour finaliser votre rendez-vous, connectez-vous ou créez un compte gratuitement.
                        </p>
                        <div class="flex flex-wrap justify-center gap-3">
                            <a href="{{ route('login') }}"
                               class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-light transition">
                                Se connecter
                            </a>
                            <a href="{{ route('register') }}"
                               class="px-5 py-2.5 bg-accent text-white text-sm font-semibold rounded-lg hover:bg-accent-600 transition">
                                Créer un compte
                            </a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </section>

@endsection