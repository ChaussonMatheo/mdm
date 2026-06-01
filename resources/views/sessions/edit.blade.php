<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <!-- Title and Theme -->
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Prêt ?</h1>
            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $session->theme }}</p>
        </div>

        <!-- Secret Code Card -->
        <div class="bg-[#E6066B] text-white rounded-3xl px-6 py-8 mb-8 text-center transform -rotate-3 hover:rotate-0 transition-transform">
            <p class="text-sm opacity-90 mb-2 transform rotate-3">Code secret</p>
            <p class="text-5xl font-black tracking-wider transform rotate-3">{{ $session->code }}</p>
        </div>

        <!-- Participants Section -->
        <div class="mb-8">
            <div class="space-y-3">
                <!-- Current User -->
                <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($session->user->name, 0, 1) }}
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $session->user->name }}</span>
                    </div>
                    <div class="w-4 h-4 rounded-full" style="background-color: #E6066B;"></div>
                </div>

                <!-- Other Participants (sample) -->
                @if($session->user->family)
                    @foreach($session->user->family->users->where('id', '!=', $session->user->id)->take(3) as $participant)
                        <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($participant->name, 0, 1) }}
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $participant->name }}</span>
                            </div>
                            <div class="w-4 h-4 rounded-full bg-gray-400"></div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Cast Button -->
        <div class="pt-8">
            <button class="w-full bg-black hover:bg-gray-900 text-white font-bold py-4 rounded-full transition-colors flex items-center justify-center gap-2">
                <span class="text-xl">📺</span>
                Caster sur la TV
            </button>
        </div>
    </div>
</x-app-layout>

