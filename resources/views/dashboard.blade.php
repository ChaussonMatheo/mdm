<x-app-layout>
    <div class="space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-welcome-card />
        </div>

        <!-- Nouvelle session section -->
        <div class="mb-8 p-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Nouvelle session</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Rejoignez ou créer une session.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Créer une session -->
                <a href="{{ route('sessions.create') }}" class="bg-[#E6066B] text-white rounded-[32px] px-8 py-6 flex items-center justify-between transition-all hover:bg-[#CC0E5F]">
                    <div class="text-left">
                        <h3 class="text-xl font-bold roundedfont mb-1">Créer une session</h3>
                        <p class="text-pink-100 text-sm">Décidez du sujet & choisissez les modules</p>
                    </div>
                    <svg class="w-6 h-6 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Rejoindre une session -->
                <div class="bg-[#64348B] text-white rounded-[32px] px-8 py-6 flex flex-col justify-between transition-all">
                    <div>
                        <h3 class="text-xl roundedfont font-bold mb-2">Rejoindre une session</h3>
                        <p class="text-purple-100 text-sm mb-4">Entrez le code</p>
                    </div>
                    <form action="{{ route('sessions.join') }}" method="POST" class="flex flex-col gap-2">
                        @csrf
                        <div class="flex items-center gap-3">
                            <input type="text" name="code" placeholder="FAM-123" class="bg-white text-purple-600 rounded-full px-4 py-2 text-center font-semibold placeholder-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-300 w-full sm:w-40" required>
                            <button type="submit" class="bg-black hover:bg-gray-900 text-white rounded-full px-6 py-2 font-semibold flex items-center gap-2 transition-all whitespace-nowrap">
                                Rejoindre
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                        @error('code')
                            <p class="text-red-200 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>

            <!-- Ministères card -->
            <a href="{{ route('ministries.index') }}" class="block bg-[#F8B803] text-gray-900 rounded-[32px] px-8 py-6 flex items-center justify-between transition-all hover:bg-[#E0A500]">
                <div class="text-left">
                    <h3 class="text-xl font-bold mb-1">🏛️ Les Ministères</h3>
                    <p class="text-gray-700 text-sm">Attribuez des responsabilités aux membres de votre famille</p>
                </div>
                <svg class="w-6 h-6 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</x-app-layout>
