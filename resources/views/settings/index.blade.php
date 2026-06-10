
<x-app-layout>
    <div class="py-6 px-4 sm:px-6 space-y-6 max-w-full overflow-hidden">
        <!-- Status Messages -->
        @if (session('status') === 'profile-updated')
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl text-sm" role="alert">
                <span>Profil mis à jour avec succès.</span>
            </div>
        @endif

        @if (session('status') === 'family-joined')
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl text-sm" role="alert">
                <span>Vous avez rejoint la famille avec succès.</span>
            </div>
        @endif

        @if (session('status') === 'family-left')
            <div class="bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-300 px-4 py-3 rounded-xl text-sm" role="alert">
                <span>Vous avez quitté votre famille.</span>
            </div>
        @endif

        <!-- Section 1: Connexion Famille -->
        <div class="bg-white dark:bg-gray-800 rounded-[32px] p-5 sm:p-6 shadow-sm">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1">Ma Famille</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-5">Gerer votre connexion familiale</p>

            @if ($user->family)
                <div class="bg-purple-50 dark:bg-purple-900/30 rounded-2xl p-4 sm:p-5 mb-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Famille connectee</p>
                            <p class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white break-words">{{ $user->family->name }}</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Code famille</p>
                            <p class="text-xl sm:text-2xl font-bold text-purple-600 dark:text-purple-400 tracking-wider break-all">{{ $user->family->unique_code }}</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('settings.family.leave') }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium underline" onclick="return confirm('Etes-vous sur de vouloir quitter cette famille ?')">
                        Quitter la famille
                    </button>
                </form>
            @else
                <div class="bg-amber-50 dark:bg-amber-900/30 rounded-2xl p-4 sm:p-5 mb-4">
                    <p class="text-sm text-amber-600 dark:text-amber-400 mb-3">Vous n'etes connecte a aucune famille.</p>

                    <form method="POST" action="{{ route('settings.family.join') }}" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <div class="flex-1 min-w-0">
                            <input type="text" name="code" placeholder="Entrez le code famille (ex: M1234)"
                                class="w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2 text-center font-semibold focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white rounded-full px-6 py-2 font-semibold transition-all whitespace-nowrap">
                            Rejoindre
                        </button>
                    </form>

                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-3">
                        Demandez le code a votre famille pour la rejoindre.
                    </p>
                </div>
            @endif
        </div>

        <!-- Section 2: Informations utilisateur -->
        <div class="bg-white dark:bg-gray-800 rounded-[32px] p-5 sm:p-6 shadow-sm">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1">Mon Profil</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-5">Modifiez vos informations personnelles</p>

            <form method="POST" action="{{ route('settings.profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                        class="w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telephone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                        class="w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3 pt-2">
                    <button type="submit" class="bg-[#E6066B] hover:bg-[#CC0E5F] text-white rounded-full px-6 py-2 font-semibold transition-all w-full sm:w-auto">
                        Enregistrer
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-600 dark:text-green-400">Enregistre</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- Section 3: Sessions actives -->
        <div class="bg-white dark:bg-gray-800 rounded-[32px] p-5 sm:p-6 shadow-sm">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1">Sessions Actives</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-5">Rejoignez une session en cours</p>

            @if ($activeSessions->count() > 0)
                <div class="space-y-3">
                    @foreach ($activeSessions as $session)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $session->status === 'active' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                    <span class="font-semibold text-gray-900 dark:text-white truncate">{{ $session->theme }}</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span>Code: <strong>{{ $session->code }}</strong></span>
                                    <span class="hidden xs:inline">•</span>
                                    <span class="truncate">Cree par {{ $session->user->name }}</span>
                                    <span>•</span>
                                    <span>{{ $session->participants->count() }} participant(s)</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-auto">
                                <span class="text-xs px-2 py-1 rounded-full whitespace-nowrap {{ $session->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    {{ $session->status === 'active' ? 'En cours' : 'Preparation' }}
                                </span>
                                <a href="{{ route('sessions.show', $session) }}"
                                    class="bg-[#64348B] hover:bg-[#52297A] text-white rounded-full px-4 py-1.5 text-sm font-semibold transition-all whitespace-nowrap">
                                    Rejoindre
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Aucune session active pour le moment.</p>
                    <a href="{{ route('sessions.create') }}" class="inline-block mt-3 text-purple-600 dark:text-purple-400 font-semibold hover:underline">
                        Creer une session →
                    </a>
                </div>
            @endif

            <!-- Join by code -->
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ou rejoindre avec un code :</p>
                <form method="POST" action="{{ route('settings.session.join') }}" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1 min-w-0">
                        <input type="text" name="session_code" placeholder="Code session (ex: ABC-123)"
                            class="w-full rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2 text-center font-semibold focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('session_code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-[#64348B] hover:bg-[#52297A] text-white rounded-full px-6 py-2 font-semibold transition-all whitespace-nowrap">
                        Rejoindre
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
