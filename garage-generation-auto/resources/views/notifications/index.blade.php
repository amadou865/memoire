<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-primary leading-tight">Mes Notifications</h2>
            @if(auth()->user()->notificationsNonLues()->count() > 0)
                <form method="POST" action="{{ route('notifications.tout-lire') }}">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-accent hover:underline">
                        Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl font-medium text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
                @forelse($notifications as $notif)
                    <div class="p-5 flex items-start justify-between gap-4 hover:bg-gray-50/80 transition {{ !$notif->lu ? 'bg-amber-50/40 border-l-4 border-accent' : '' }}">
                        <div class="flex gap-4">
                            <div class="text-2xl mt-1">🔔</div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-gray-900 text-base">{{ $notif->titre }}</h4>
                                    @if(!$notif->lu)
                                        <span class="px-2 py-0.5 bg-accent text-white text-[10px] font-extrabold rounded-full uppercase">Nouveau</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $notif->message }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $notif->date_envoi->format('d/m/Y à H:i') }} ({{ $notif->date_envoi->diffForHumans() }})</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            @if($notif->lien)
                                <a href="{{ route('notifications.lire', $notif) }}"
                                   class="px-3 py-1.5 bg-primary hover:bg-primary-light text-white text-xs font-semibold rounded-lg transition">
                                    Voir →
                                </a>
                            @elseif(!$notif->lu)
                                <form method="POST" action="{{ route('notifications.lire', $notif) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-xs text-gray-500 hover:text-primary underline">Marquer lu</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('notifications.destroy', $notif) }}" onsubmit="return confirm('Supprimer cette notification ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-red-500 transition p-1" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-400">
                        <div class="text-4xl mb-2">🔕</div>
                        <p class="font-medium">Vous n'avez aucune notification pour le moment.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="mt-6">{{ $notifications->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>