<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- Logo --}}
            <a href="{{ route('accueil') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Génération Automobile"
                     class="h-14 w-auto object-contain">
                <span class="hidden sm:block text-primary font-bold text-xl">
                    Génération <span class="text-accent">Automobile</span>
                </span>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('accueil') }}"
                   class="{{ request()->routeIs('accueil') ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }} transition-colors duration-200">
                    Accueil
                </a>
                <a href="#services" class="text-gray-600 hover:text-primary transition-colors duration-200">
                    Nos services
                </a>
                <a href="#creneaux" class="text-gray-600 hover:text-primary transition-colors duration-200">
                    Créneaux
                </a>
                <a href="{{ route('login') }}" class="bg-primary hover:bg-primary-light text-white font-semibold px-6 py-2.5 rounded-lg transition-all duration-200">
                    Connexion
                </a>
            </div>

            {{-- Bouton menu mobile --}}
            <button id="mobile-menu-btn" class="lg:hidden text-primary p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>

        {{-- Menu Mobile --}}
        <div id="mobile-menu" class="hidden lg:hidden pb-4 space-y-1 border-t border-gray-100 pt-4">
            <a href="{{ route('accueil') }}" class="block text-gray-600 hover:text-primary hover:bg-gray-50 px-4 py-2 rounded-lg">Accueil</a>
            <a href="#services" class="block text-gray-600 hover:text-primary hover:bg-gray-50 px-4 py-2 rounded-lg">Nos services</a>
            <a href="#creneaux" class="block text-gray-600 hover:text-primary hover:bg-gray-50 px-4 py-2 rounded-lg">Créneaux</a>
            <a href="{{ route('login') }}" class="block bg-primary text-white px-4 py-2 rounded-lg font-semibold text-center mt-2">Connexion</a>
        </div>

    </div>
</nav>

{{-- Script pour le menu mobile --}}
<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>