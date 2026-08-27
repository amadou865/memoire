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
                    <a href="{{ route('client.devis.index') }}" class="{{ request()->routeIs('client.devis.*') ? 'bg-accent text-white' : 'text-white hover:bg-primary-light' }} px-4 py-2 rounded-lg font-medium text-sm">Mes Devis</a>
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

            {{-- User Right Profile & Notifications --}}
            <div class="hidden lg:flex items-center gap-3">

                {{-- 🔔 CLOCHE DE NOTIFICATION --}}
                @php
                    $countNonLues = auth()->user()->notificationsNonLues()->count();
                    $notifsAffichees = auth()->user()->notificationsNonLues()->take(5)->get();
                @endphp

                <div class="relative" x-data="{ openNotif: false }">
                    <button @click="openNotif = !openNotif" type="button" class="relative p-2 text-white hover:bg-primary-light rounded-lg transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>

                        @if($countNonLues > 0)
                            <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-accent text-[10px] font-extrabold text-white">
                                {{ $countNonLues > 9 ? '9+' : $countNonLues }}
                            </span>
                        @endif
                    </button>

                    <div x-show="openNotif" @click.outside="openNotif = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 text-gray-800" style="display: none;">
                        <div class="p-4 bg-primary text-white flex justify-between items-center">
                            <span class="font-bold text-sm">Notifications</span>
                            @if($countNonLues > 0)
                                <span class="text-xs bg-accent text-white px-2 py-0.5 rounded-full font-bold">{{ $countNonLues }} nouvelle(s)</span>
                            @endif
                        </div>

                        <div class="max-h-72 overflow-y-auto divide-y divide-gray-100">
                            @forelse($notifsAffichees as $n)
                                <a href="{{ route('notifications.lire', $n) }}" class="block p-3 hover:bg-amber-50/50 transition">
                                    <p class="font-bold text-xs text-primary">{{ $n->titre }}</p>
                                    <p class="text-xs text-gray-600 truncate mt-0.5">{{ $n->message }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ $n->date_envoi->diffForHumans() }}</p>
                                </a>
                            @empty
                                <div class="p-6 text-center text-xs text-gray-400">Aucune nouvelle notification</div>
                            @endforelse
                        </div>

                        <div class="p-3 bg-gray-50 border-t text-center">
                            <a href="{{ route('notifications.index') }}" class="text-xs font-bold text-accent hover:underline">Voir toutes les notifications →</a>
                        </div>
                    </div>
                </div>

                {{-- Role Badge --}}
                <span class="bg-accent/20 text-accent px-3 py-1 rounded-full text-xs font-semibold uppercase">
                    @if(auth()->user()->isClient()) Client
                    @elseif(auth()->user()->isReceptionniste()) Réceptionniste
                    @elseif(auth()->user()->isChefDepartement()) Chef Dép.
                    @elseif(auth()->user()->isDirecteurTechnique()) Dir. Tech.
                    @elseif(auth()->user()->isAdministrateur()) Admin
                    @endif
                </span>

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-white hover:bg-primary-light px-3 py-2 rounded-lg">
                        <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                        </div>
                        <span class="text-sm">{{ auth()->user()->prenom }}</span>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border overflow-hidden text-gray-800" style="display: none;">
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold text-primary">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Mon Profil</a>
                        <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Mes Notifications</a>
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
                <a href="{{ route('client.devis.index') }}" class="block text-white px-4 py-2 rounded-lg">Mes Devis</a>
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

            <a href="{{ route('notifications.index') }}" class="block text-white px-4 py-2 rounded-lg">🔔 Notifications ({{ $countNonLues }})</a>

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