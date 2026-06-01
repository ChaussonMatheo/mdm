<x-app-layout>
    <x-slot name="headerLeft">
        <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
            <i data-lucide="chevron-left" class="w-8 h-8"></i>
        </a>
    </x-slot>

    <div class="min-h-screen  px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            @if ($message = Session::get('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800">{{ $message }}</p>
                </div>
            @endif

            <form action="{{ route('avatar.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')

                <!-- Preview -->
                <div class="bg-white rounded-2xl ">
                    <div id="avatarPreview" class="text-center py-6 justify-center bg-[#FAEA2F] rounded-xl">
                        <x-avatar-frame :colors="$avatarColors" />
                        <p class="text-2xl text-[#E6066B] font-bold">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                <!-- Color Customization -->
                <div class="bg-white rounded-2xl">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Personnalisez vos couleurs</h2>

                    <div class="space-y-8">
                        <!-- Couleur de la peau -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-3">Couleur de la peau</label>
                            <div class="flex gap-3 flex-wrap">
                                @foreach(['#f5a57f', '#f9c09d', '#e8aa80', '#d6956a', '#c97f5f', '#a86c50', '#8b6239', '#dbbea1', '#e5b8a2', '#f1c27d'] as $color)
                                    <input
                                        type="radio"
                                        name="avatar_colors[skin]"
                                        value="{{ $color }}"
                                        id="skin-{{ $loop->index }}"
                                        {{ ($avatarColors['skin'] ?? '#f5a57f') === $color ? 'checked' : '' }}
                                        class="sr-only peer"
                                        onchange="updatePreview()"
                                    >
                                    <label
                                        for="skin-{{ $loop->index }}"
                                        class="w-8 h-8 rounded-full cursor-pointer border border-transparent peer-checked:border-black transition-all"
                                        style="background-color: {{ $color }}"
                                    ></label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Couleur des cheveux -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-3">Couleur des cheveux</label>
                            <div class="flex gap-3 flex-wrap">
                                @foreach(['#1a1a1a', '#2d2d2d', '#3d3d3d', '#5a4a3a', '#8b6f47', '#6b4423', '#c68642', '#d4a373', '#e8b88a', '#f5deb3'] as $color)
                                    <input
                                        type="radio"
                                        name="avatar_colors[hair]"
                                        value="{{ $color }}"
                                        id="hair-{{ $loop->index }}"
                                        {{ ($avatarColors['hair'] ?? '#2d2d2d') === $color ? 'checked' : '' }}
                                        class="sr-only peer"
                                        onchange="updatePreview()"
                                    >
                                    <label
                                        for="hair-{{ $loop->index }}"
                                        class="w-8 h-8 rounded-full cursor-pointer border border-transparent peer-checked:border-black transition-all"
                                        style="background-color: {{ $color }}"
                                    ></label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Couleur d'arrière plan -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-3">Couleur secondaire</label>
                            <div class="flex gap-3 flex-wrap">
                                @foreach(['#faea2f', '#ffd700', '#ffb700', '#ff9500', '#ff7f00'] as $color)
                                    <input
                                        type="radio"
                                        name="avatar_colors[secondary]"
                                        value="{{ $color }}"
                                        id="secondary-{{ $loop->index }}"
                                        {{ ($avatarColors['secondary'] ?? '#faea2f') === $color ? 'checked' : '' }}
                                        class="sr-only peer"
                                        onchange="updatePreview()"
                                    >
                                    <label
                                        for="secondary-{{ $loop->index }}"
                                        class="w-8 h-8 rounded-full cursor-pointer border border-transparent peer-checked:border-black transition-all"
                                        style="background-color: {{ $color }}"
                                    ></label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Couleur d'accent -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-3">Couleur d'accent</label>
                            <div class="flex gap-3 flex-wrap">
                                @foreach(['#f2969f', '#ff69b4', '#e91e63', '#c2185b', '#880e4f'] as $color)
                                    <input
                                        type="radio"
                                        name="avatar_colors[accent]"
                                        value="{{ $color }}"
                                        id="accent-{{ $loop->index }}"
                                        {{ ($avatarColors['accent'] ?? '#f2969f') === $color ? 'checked' : '' }}
                                        class="sr-only peer"
                                        onchange="updatePreview()"
                                    >
                                    <label
                                        for="accent-{{ $loop->index }}"
                                        class="w-8 h-8 rounded-full cursor-pointer border border-transparent peer-checked:border-black transition-all"
                                        style="background-color: {{ $color }}"
                                    ></label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 justify-center">
                    <button
                        type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-pink-600 to-pink-500 text-white font-bold rounded-full hover:shadow-lg transition-shadow"
                    >
                        Enregistrer mon avatar
                    </button>
                    <a
                        href="{{ route('dashboard') }}"
                        class="px-8 py-3 bg-gray-200 text-gray-900 font-bold rounded-full hover:bg-gray-300 transition-colors"
                    >
                        Annuler
                    </a>
                </div>

                @if ($errors->any())
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800 font-bold mb-2">Erreurs de validation :</p>
                        <ul class="list-disc list-inside text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        function updatePreview() {
            const skinColor = document.querySelector('input[name="avatar_colors[skin]"]:checked').value;
            const hairColor = document.querySelector('input[name="avatar_colors[hair]"]:checked').value;
            const secondaryColor = document.querySelector('input[name="avatar_colors[secondary]"]:checked').value;
            const accentColor = document.querySelector('input[name="avatar_colors[accent]"]:checked').value;

            // Update SVG styles
            const svg = document.getElementById('avatar-svg');
            if (svg) {
                const styles = svg.querySelector('style');
                if (styles) {
                    styles.textContent = `.cls-1 { fill: #010202; }
                        .cls-2 { fill: ${skinColor}; }
                        .cls-3 { fill: #fff; }
                        .cls-4 { fill: #070303; }
                        .cls-5 { fill: ${skinColor}; }
                        .cls-6 { fill: ${secondaryColor}; }
                        .cls-7 { fill: ${accentColor}; }
                        .cls-8 { fill: ${hairColor}; }`;
                }
            }
        }
    </script>
</x-app-layout>
