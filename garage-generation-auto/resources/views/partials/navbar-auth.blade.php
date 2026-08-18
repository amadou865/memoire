<nav class="bg-primary shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('accueil') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Génération Automobile"
                     class="h-10 w-auto object-contain">
                <span class="hidden md:block text-white font-bold text-lg">
                    Génération <span class="text-accent">Automobile</span>
                </span>
            </a>

            {{-- Menu Desktop dynamique selon le rôle --}}
            <div class="hidden lg:flex items-center gap-1">

                {{-- Lien commun : Accueil --}}
                <a href="{{ route('accueil') }}"
                   class="{{ request()->routeIs('accueil') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                    Accueil
                </a>

                {{-- ═══════════════════════════════════════════ --}}
                {{-- MENU CLIENT --}}
                {{-- ═══════════════════════════════════════════ --}}
                @if(auth()->user()->isClient())
                    <a href="{{ route('client.dashboard') }}"
                       class="{{ request()->routeIs('client.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Tableau de bord
                    </a>
                    <a href="{{ route('client.rendez-vous.index') }}"
                       class="{{ request()->routeIs('client.rendez-vous.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Mes Rendez-vous
                    </a>
                    <a href="{{ route('client.vehicules.index') }}"
                       class="{{ request()->routeIs('client.vehicules.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Mes Véhicules
                    </a>
                    <a href="{{ route('client.interventions.index') }}"
                       class="{{ request()->routeIs('client.interventions.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Historique
                    </a>
                    <a href="{{ route('client.factures.index') }}"
                       class="{{ request()->routeIs('client.factures.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Mes Factures
                    </a>
                @endif

                {{-- ═══════════════════════════════════════════ --}}
                {{-- MENU RÉCEPTIONNISTE --}}
                {{-- ═══════════════════════════════════════════ --}}
                @if(auth()->user()->isReceptionniste())
                    <a href="{{ route('receptionniste.dashboard') }}"
                       class="{{ request()->routeIs('receptionniste.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Tableau de bord
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Rendez-vous
                    </a>
                    <a href="{{ route('receptionniste.clients.index') }}"
                       class="{{ request()->routeIs('receptionniste.clients.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Clients
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Interventions
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Devis
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Factures
                    </a>
                @endif

                {{-- ═══════════════════════════════════════════ --}}
                {{-- MENU CHEF DE DÉPARTEMENT --}}
                {{-- ═══════════════════════════════════════════ --}}
                @if(auth()->user()->isChefDepartement())
                    <a href="{{ route('chef.dashboard') }}"
                       class="{{ request()->routeIs('chef.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Tableau de bord
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Mes Interventions
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Diagnostics
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Pièces Détachées
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Stock
                    </a>
                @endif

                {{-- ═══════════════════════════════════════════ --}}
                {{-- MENU DIRECTEUR TECHNIQUE --}}
                {{-- ═══════════════════════════════════════════ --}}
                @if(auth()->user()->isDirecteurTechnique())
                    <a href="{{ route('directeur.dashboard') }}"
                       class="{{ request()->routeIs('directeur.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Tableau de bord
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Contrôle Qualité
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Essais
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Validations
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Statistiques
                    </a>
                @endif

                {{-- ═══════════════════════════════════════════ --}}
                {{-- MENU ADMINISTRATEUR --}}
                {{-- ═══════════════════════════════════════════ --}}
                @if(auth()->user()->isAdministrateur())
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Tableau de bord
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Utilisateurs
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Stock
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Statistiques
                    </a>
                    <a href="#" class="text-white hover:bg-primary-light px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                        Paramètres
                    </a>
                @endif

            </div>

            {{-- Menu utilisateur (à droite) --}}
            <div class="hidden lg:flex items-center gap-3">

                {{-- Badge du rôle --}}
                <span class="bg-accent/20 text-accent px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider">
                    @if(auth()->user()->isClient()) Client
                    @elseif(auth()->user()->isReceptionniste()) Réceptionniste
                    @elseif(auth()->user()->isChefDepartement()) Chef Dép.
                    @elseif(auth()->user()->isDirecteurTechnique()) Dir. Tech.
                    @elseif(auth()->user()->isAdministrateur()) Admin
                    @endif
                </span>

                {{-- Dropdown Profil --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-white hover:bg-primary-light px-3 py-2 rounded-lg transition-all">
                        <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                        </div>
                        <span class="text-sm">{{ auth()->user()->prenom }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Menu déroulant --}}
                    <div x-show="open"
                         @click.outside="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden"
                         style="display: none;">

                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-primary">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Mon Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Bouton menu mobile --}}
            <button id="mobile-menu-btn-auth" class="lg:hidden text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- MENU MOBILE --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div id="mobile-menu-auth" class="hidden lg:hidden pb-4 space-y-1 border-t border-primary-light pt-4">

            {{-- Info utilisateur --}}
            <div class="px-4 py-3 bg-primary-light rounded-lg mb-2">
                <p class="text-white font-semibold text-sm">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                <p class="text-gray-300 text-xs">{{ auth()->user()->email }}</p>
                <span class="inline-block mt-2 bg-accent text-white px-2 py-0.5 rounded text-xs font-semibold">
                    @if(auth()->user()->isClient()) Client
                    @elseif(auth()->user()->isReceptionniste()) Réceptionniste
                    @elseif(auth()->user()->isChefDepartement()) Chef Département
                    @elseif(auth()->user()->isDirecteurTechnique()) Directeur Technique
                    @elseif(auth()->user()->isAdministrateur()) Administrateur
                    @endif
                </span>
            </div>

            <a href="{{ route('accueil') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Accueil</a>

            {{-- Liens mobiles selon le rôle --}}
            @if(auth()->user()->isClient())
                <a href="{{ route('client.dashboard') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="{{ route('client.rendez-vous.index') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Mes Rendez-vous</a>
                <a href="{{ route('client.vehicules.index') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Mes Véhicules</a>
                <a href="{{ route('client.interventions.index') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Historique</a>
                <a href="{{ route('client.factures.index') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Mes Factures</a>
            @endif

            @if(auth()->user()->isReceptionniste())
                <a href="{{ route('receptionniste.dashboard') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Rendez-vous</a>
                <a href="{{ route('receptionniste.clients.index') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Clients</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Interventions</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Devis</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Factures</a>
            @endif

            @if(auth()->user()->isChefDepartement())
                <a href="{{ route('chef.dashboard') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Mes Interventions</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Diagnostics</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Pièces Détachées</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Stock</a>
            @endif

            @if(auth()->user()->isDirecteurTechnique())
                <a href="{{ route('directeur.dashboard') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Contrôle Qualité</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Essais</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Validations</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Statistiques</a>
            @endif

            @if(auth()->user()->isAdministrateur())
                <a href="{{ route('admin.dashboard') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Utilisateurs</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Stock</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Statistiques</a>
                <a href="#" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg">Paramètres</a>
            @endif

            <a href="{{ route('profile.edit') }}" class="block text-white hover:bg-primary-light px-4 py-2 rounded-lg mt-2 border-t border-primary-light pt-3">Mon Profil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block text-red-300 hover:bg-red-900/30 px-4 py-2 rounded-lg">
                    Déconnexion
                </button>
            </form>
        </div>

    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn-auth').addEventListener('click', function() {
        document.getElementById('mobile-menu-auth').classList.toggle('hidden');
    });
</script>