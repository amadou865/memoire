<nav class="bg-primary shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('accueil') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Génération Automobile" class="h-10 w-auto object-contain">
                <span class="hidden md:block text-white font-bold text-lg">
                    Génération <span class="text-accent">Automobile</span>
                </span>
            </a>

            {{-- Menu Desktop dynamique --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('accueil') }}" class="{{ request()->routeIs('accueil') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">
                    Accueil
                </a>

                @if(auth()->user()->isClient())
                    <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Tableau de bord</a>
                    <a href="{{ route('client.rendez-vous.index') }}" class="{{ request()->routeIs('client.rendez-vous.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Mes Rendez-vous</a>
                    <a href="{{ route('client.vehicules.index') }}" class="{{ request()->routeIs('client.vehicules.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Mes Véhicules</a>
                    <a href="{{ route('client.interventions.index') }}" class="{{ request()->routeIs('client.interventions.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Historique</a>
                    <a href="{{ route('client.factures.index') }}" class="{{ request()->routeIs('client.factures.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Mes Factures</a>
                @endif

                @if(auth()->user()->isReceptionniste())
                    <a href="{{ route('receptionniste.dashboard') }}" class="{{ request()->routeIs('receptionniste.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Tableau de bord</a>
                    <a href="{{ route('receptionniste.rendez-vous.index') }}" class="{{ request()->routeIs('receptionniste.rendez-vous.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Rendez-vous</a>
                    <a href="{{ route('receptionniste.clients.index') }}" class="{{ request()->routeIs('receptionniste.clients.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Clients</a>
                    <a href="{{ route('receptionniste.interventions.index') }}" class="{{ request()->routeIs('receptionniste.interventions.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Interventions</a>
                    <a href="{{ route('receptionniste.devis.index') }}" class="{{ request()->routeIs('receptionniste.devis.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Devis</a>
                    <a href="{{ route('receptionniste.factures.index') }}" class="{{ request()->routeIs('receptionniste.factures.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Factures</a>
                @endif

                @if(auth()->user()->isChefDepartement())
                    <a href="{{ route('chef.dashboard') }}" class="{{ request()->routeIs('chef.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Tableau de bord</a>
                    <a href="{{ route('chef.interventions.index') }}" class="{{ request()->routeIs('chef.interventions.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Mes Interventions</a>
                    <a href="{{ route('chef.stock') }}" class="{{ request()->routeIs('chef.stock') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Stock</a>
                @endif

                @if(auth()->user()->isDirecteurTechnique())
                    <a href="{{ route('directeur.dashboard') }}" class="{{ request()->routeIs('directeur.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Tableau de bord</a>
                    <a href="{{ route('directeur.controle-qualite.index') }}" class="{{ request()->routeIs('directeur.controle-qualite.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Contrôle Qualité</a>
                    <a href="{{ route('directeur.statistiques') }}" class="{{ request()->routeIs('directeur.statistiques') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Statistiques</a>
                @endif

                @if(auth()->user()->isAdministrateur())
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Tableau de bord</a>
                    <a href="{{ route('admin.utilisateurs.index') }}" class="{{ request()->routeIs('admin.utilisateurs.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Utilisateurs</a>
                    <a href="{{ route('admin.stock.index') }}" class="{{ request()->routeIs('admin.stock.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Stock</a>
                    <a href="{{ route('admin.statistiques') }}" class="{{ request()->routeIs('admin.statistiques') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Statistiques</a>
                    <a href="{{ route('admin.parametres') }}" class="{{ request()->routeIs('admin.parametres') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Paramètres</a>
                @endif
            </div>

            {{-- User Right Profile --}}
            <div class="hidden lg:flex items-center gap-3">
                <span class="bg-accent/20 text-accent px-3 py-1 rounded-full text-xs font-semibold uppercase">
                    @if(auth()->user()->isClient()) Client
                    @elseif(auth()->user()->isReceptionniste()) Réceptionniste
                    @elseif(auth()->user()->isChefDepartement()) Chef Dép.
                    @elseif(auth()->user()->isDirecteurTechnique()) Dir. Tech.
                    @elseif(auth()->user()->isAdministrateur()) Admin
                    @endif
                </span>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-white hover:bg-primary-light px-3 py-2 rounded-lg">
                        <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                        </div>
                        <span class="text-sm">{{ auth()->user()->prenom }}</span>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border overflow-hidden" style="display: none;">
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold text-primary">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Mon Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile Button --}}
            <button id="mobile-menu-btn-auth" class="lg:hidden text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu-auth" class="hidden lg:hidden pb-4 space-y-1 border-t border-primary-light pt-4">
            <a href="{{ route('accueil') }}" class="block text-white px-4 py-2 rounded-lg">Accueil</a>

            @if(auth()->user()->isClient())
                <a href="{{ route('client.dashboard') }}" class="block text-white px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="{{ route('client.rendez-vous.index') }}" class="block text-white px-4 py-2 rounded-lg">Mes Rendez-vous</a>
                <a href="{{ route('client.vehicules.index') }}" class="block text-white px-4 py-2 rounded-lg">Mes Véhicules</a>
                <a href="{{ route('client.interventions.index') }}" class="block text-white px-4 py-2 rounded-lg">Historique</a>
                <a href="{{ route('client.factures.index') }}" class="block text-white px-4 py-2 rounded-lg">Mes Factures</a>
            @endif

            @if(auth()->user()->isReceptionniste())
                <a href="{{ route('receptionniste.dashboard') }}" class="block text-white px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="{{ route('receptionniste.rendez-vous.index') }}" class="block text-white px-4 py-2 rounded-lg">Rendez-vous</a>
                <a href="{{ route('receptionniste.clients.index') }}" class="block text-white px-4 py-2 rounded-lg">Clients</a>
                <a href="{{ route('receptionniste.interventions.index') }}" class="block text-white px-4 py-2 rounded-lg">Interventions</a>
                <a href="{{ route('receptionniste.devis.index') }}" class="block text-white px-4 py-2 rounded-lg">Devis</a>
                <a href="{{ route('receptionniste.factures.index') }}" class="block text-white px-4 py-2 rounded-lg">Factures</a>
            @endif

            @if(auth()->user()->isChefDepartement())
                <a href="{{ route('chef.dashboard') }}" class="block text-white px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="{{ route('chef.interventions.index') }}" class="block text-white px-4 py-2 rounded-lg">Mes Interventions</a>
                <a href="{{ route('chef.stock') }}" class="block text-white px-4 py-2 rounded-lg">Stock</a>
            @endif

            @if(auth()->user()->isDirecteurTechnique())
                <a href="{{ route('directeur.dashboard') }}" class="block text-white px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="{{ route('directeur.controle-qualite.index') }}" class="block text-white px-4 py-2 rounded-lg">Contrôle Qualité</a>
                <a href="{{ route('directeur.statistiques') }}" class="block text-white px-4 py-2 rounded-lg">Statistiques</a>
            @endif

            @if(auth()->user()->isAdministrateur())
                <a href="{{ route('admin.dashboard') }}" class="block text-white px-4 py-2 rounded-lg">Tableau de bord</a>
                <a href="{{ route('admin.utilisateurs.index') }}" class="block text-white px-4 py-2 rounded-lg">Utilisateurs</a>
                <a href="{{ route('admin.stock.index') }}" class="block text-white px-4 py-2 rounded-lg">Stock</a>
                <a href="{{ route('admin.statistiques') }}" class="block text-white px-4 py-2 rounded-lg">Statistiques</a>
                <a href="{{ route('admin.parametres') }}" class="block text-white px-4 py-2 rounded-lg">Paramètres</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-red-300 px-4 py-2 rounded-lg">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn-auth').addEventListener('click', function() {
        document.getElementById('mobile-menu-auth').classList.toggle('hidden');
    });
</script>