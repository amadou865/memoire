<footer class="bg-primary text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Colonne 1 : Logo & Description --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Génération Automobile"
                         class="h-16 w-auto object-contain rounded-lg">
                    <h3 class="text-2xl font-bold">
                        Génération <span class="text-accent">Automobile</span>
                    </h3>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Votre partenaire automobile de confiance à Dakar.
                    Plus de 10 ans d'expertise au service de votre véhicule.
                </p>
            </div>

            {{-- Colonne 2 : Contact --}}
            <div>
                <h4 class="text-accent font-bold text-sm tracking-wider mb-4">CONTACT</h4>
                <ul class="space-y-3 text-gray-300">
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Cambérène, Dakar<br>Sénégal</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+221 77 123 45 67</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>contact@generation-auto.sn</span>
                    </li>
                </ul>
            </div>

            {{-- Colonne 3 : Horaires --}}
            <div>
                <h4 class="text-accent font-bold text-sm tracking-wider mb-4">HORAIRES</h4>
                <ul class="space-y-3 text-gray-300">
                    <li class="flex justify-between">
                        <span>Lun - Ven</span>
                        <span class="font-medium">8h - 18h</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Samedi</span>
                        <span class="font-medium">8h - 13h</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Dimanche</span>
                        <span class="font-medium text-red-400">Fermé</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Copyright --}}
        <div class="mt-12 pt-8 border-t border-primary-light/30 text-center text-gray-400 text-sm">
            <p>© {{ date('Y') }} Génération Automobile - Tous droits réservés</p>
        </div>
    </div>
</footer>