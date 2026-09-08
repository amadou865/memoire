<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-primary">Connexion</h1>
        <p class="text-sm text-gray-500 mt-1">Accédez à votre espace Génération Automobile</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        @if(request('redirect'))
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
        @endif

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" class="text-primary font-semibold" />
            <x-text-input id="email"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
                          autofocus
                          autocomplete="username"
                          placeholder="ex: client@garage.sn" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div>
            <x-input-label for="password" value="Mot de passe" class="text-primary font-semibold" />
            <x-text-input id="password"
                          class="block mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                          type="password"
                          name="password"
                          required
                          autocomplete="current-password"
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Se souvenir -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-gray-300 text-accent shadow-sm focus:ring-accent"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-accent hover:underline font-medium"
                   href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Bouton -->
        <div>
            <button type="submit"
                    class="w-full py-3 px-4 bg-primary hover:bg-primary-light text-white font-bold rounded-xl shadow-md shadow-primary/20 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2">
                Se connecter
            </button>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-600">
            Vous n'avez pas encore de compte ?
        </p>
        <a href="{{ route('register', request()->only('redirect')) }}"
           class="inline-block mt-2 text-accent font-bold hover:underline text-sm">
            Créer un compte pour prendre RDV →
        </a>
    </div>
</x-guest-layout>