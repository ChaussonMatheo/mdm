<x-app-layout>
    <x-slot name="header">
        <p>pas de header</p>
    </x-slot>
    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Preparation section -->
        <div class="mb-12">
            <!-- Logo centered -->
            <div class="mb-12 flex justify-center">
                <img src="{{ asset('logo/LOGO_MM.svg') }}" alt="MM Logo" class="w-20 h-auto">
            </div>

            <!-- Title and Description -->
            <div class="mb-8">
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-4">PRÉPARER</h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed max-w-sm">
                    Écrivez le thème de la discussion et de la décision à prendre, et choisissez parmi les 20 modules ceux qui vous intéressent.
                    <span class="text-pink-600 font-bold">Il est conseillé de choisir au moins un module de chaque famille.</span>
                </p>
            </div>

            <!-- Theme Input Form -->
            <form action="{{ route('sessions.choose-modules') }}" method="GET" id="sessionForm" class="space-y-8">
                <!-- Search/Theme Input -->
                <div>
                    <input
                        type="text"
                        name="theme"
                        id="theme"
                        placeholder="Quelle décision ?"
                        value="{{ old('theme') }}"
                        class="w-full px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-full dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-lg"
                        required
                    >
                    @error('theme')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recent Themes Section -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-4">Thèmes récents</h3>
                    <ul class="space-y-3">
                        <li>
                            <button type="button" onclick="document.getElementById('theme').value = 'Tarte à la pomme ou fraise ?'; document.getElementById('sessionForm').submit();" class="w-full flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-500 transition-colors text-sm">
                                <span>Tarte à la pomme ou fraise ?</span>
                                <span class="text-lg">›</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="document.getElementById('theme').value = 'Tarte à la pomme ou fraise ?'; document.getElementById('sessionForm').submit();" class="w-full flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-500 transition-colors text-sm">
                                <span>Tarte à la pomme ou fraise ?</span>
                                <span class="text-lg">›</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="document.getElementById('theme').value = 'Tarte à la pomme ou fraise ?'; document.getElementById('sessionForm').submit();" class="w-full flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-500 transition-colors text-sm">
                                <span>Tarte à la pomme ou fraise ?</span>
                                <span class="text-lg">›</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="document.getElementById('theme').value = 'Tarte à la pomme ou fraise ?'; document.getElementById('sessionForm').submit();" class="w-full flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-500 transition-colors text-sm">
                                <span>Tarte à la pomme ou fraise ?</span>
                                <span class="text-lg">›</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="document.getElementById('theme').value = 'Tarte à la pomme ou fraise ?'; document.getElementById('sessionForm').submit();" class="w-full flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-500 transition-colors text-sm">
                                <span>Tarte à la pomme ou fraise ?</span>
                                <span class="text-lg">›</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Choose Modules Button -->
                <div class="pt-8">
                    <button
                        type="submit"
                        class="w-full bg-black hover:bg-gray-900 text-white font-bold py-4 rounded-full transition-colors flex items-center justify-center gap-2"
                    >
                        Choisir modules
                        <span class="text-lg">›</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

