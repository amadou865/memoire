<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-primary">Créer un compte</h1>
        <p class="text-sm text-gray-500 mt-1">Rejoignez Génération Automobile</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        @if(request('redirect'))
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
        @endif

        <!-- Nom -->
        <div>
            <x-input-label for="nom" value="Nom" class="text-primary font-semibold" />
            <x-text-input id="nom" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="text" name="nom" :value="old('nom')" required autofocus autocomplete="family-name" />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Prénom -->
        <div>
            <x-input-label for="prenom" value="Prénom" class="text-primary font-semibold" />
            <x-text-input id="prenom" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="text" name="prenom" :value="old('prenom')" required autocomplete="given-name" />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" class="text-primary font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Téléphone -->
        <div>
            <x-input-label for="telephone" value="Téléphone" class="text-primary font-semibold" />
            <x-text-input id="telephone" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="text" name="telephone" :value="old('telephone')" required placeholder="+221 77 000 00 00" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div>
            <x-input-label for="password" value="Mot de passe" class="text-primary font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation -->
        <div>
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" class="text-primary font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full py-3 px-4 bg-accent hover:bg-orange-600 text-white font-bold rounded-xl shadow-md shadow-accent/25 transition-all duration-200">
                Créer mon compte
            </button>
        </div>
    </form>

    <div class="mt-6 pt-5 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-600">
            Déjà un compte ?
            <a href="{{ route('login', request()->only('redirect')) }}"
               class="text-primary font-bold hover:underline">
                Se connecter
            </a>
        </p>
    </div>
</x-guest-layout>