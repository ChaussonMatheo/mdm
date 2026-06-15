@php
function prefixSvgClasses(string $svg, string $prefix): string {
    $svg = preg_replace('/\.(cls-\d+)/', '.' . $prefix . '-$1', $svg);
    $svg = preg_replace_callback('/\bclass="([^"]+)"/', function($m) use ($prefix) {
        return 'class="' . preg_replace('/\bcls-(\d+)\b/', $prefix . '-cls-$1', $m[1]) . '"';
    }, $svg);
    return $svg;
}
@endphp
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

            <form action="{{ route('avatar.update') }}" method="POST" class="space-y-8" id="avatarForm">
                @csrf
                @method('PATCH')

                <!-- Preview -->
                <div class="bg-white rounded-2xl ">
                    <div id="avatarPreview" class="text-center py-6 justify-center bg-[#FAEA2F] rounded-xl">
                        <x-avatar-frame :colors="$avatarColors" :style="$avatarStyle" />
                        <p class="text-2xl text-[#E6066B] font-bold">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                <!-- Style Selection: Visage, Traits, Cheveux -->
                <div class="bg-white rounded-2xl space-y-6">

                    <!-- Visage -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Forme du visage</h3>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                            @foreach($faces as $key => $svgContent)
                                @php $num = str_replace('Perso-', '', $key); $pfx = 'f' . $num; @endphp
                                <label for="face-{{ $key }}" class="cursor-pointer" data-svg-category="face" data-svg-key="{{ $key }}">
                                    <input type="radio" name="avatar_style[face]" value="{{ $key }}" id="face-{{ $key }}"
                                        {{ ($avatarStyle['face'] ?? 'Perso-18') === $key ? 'checked' : '' }}
                                        class="sr-only peer"
                                        onchange="submitAvatarForm()"
                                    >
                                    <div class="p-1 rounded-xl border-2 border-transparent peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all hover:bg-gray-50">
                                        <div style="--skin: {{ $avatarColors['skin'] ?? '#f5a57f' }}; --secondary: {{ $avatarColors['secondary'] ?? '#faea2f' }}; --accent: {{ $avatarColors['accent'] ?? '#f2969f' }}; --hair: {{ $avatarColors['hair'] ?? '#2d2d2d' }};">
                                            {!! str_replace('<svg', '<svg style="width:100%;height:auto;max-width:50px"', prefixSvgClasses($svgContent, $pfx)) !!}
                                        </div>
                                        <p class="text-xs text-center font-medium text-gray-700">Visage {{ $num }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Traits du visage -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Yeux, nez, bouche</h3>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                            @foreach($features as $key => $svgContent)
                                @php $num = str_replace('Perso-', '', $key); $pfx = 't' . $num; @endphp
                                <label for="feat-{{ $key }}" class="cursor-pointer" data-svg-category="features" data-svg-key="{{ $key }}">
                                    <input type="radio" name="avatar_style[features]" value="{{ $key }}" id="feat-{{ $key }}"
                                        {{ ($avatarStyle['features'] ?? 'Perso-23') === $key ? 'checked' : '' }}
                                        class="sr-only peer"
                                        onchange="submitAvatarForm()"
                                    >
                                    <div class="p-1 rounded-xl border-2 border-transparent peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all hover:bg-gray-50">
                                        <div style="--skin: {{ $avatarColors['skin'] ?? '#f5a57f' }}; --secondary: {{ $avatarColors['secondary'] ?? '#faea2f' }}; --accent: {{ $avatarColors['accent'] ?? '#f2969f' }}; --hair: {{ $avatarColors['hair'] ?? '#2d2d2d' }};">
                                            {!! str_replace('<svg', '<svg style="width:100%;height:auto;max-width:50px"', prefixSvgClasses($svgContent, $pfx)) !!}
                                        </div>
                                        <p class="text-xs text-center font-medium text-gray-700">Traits {{ $num }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cheveux -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Coiffure</h3>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                            @foreach($hairstyles as $key => $svgContent)
                                @php $num = str_replace('Perso-', '', $key); $pfx = 'h' . $num; @endphp
                                <label for="hair-style-{{ $key }}" class="cursor-pointer" data-svg-category="hair" data-svg-key="{{ $key }}">
                                    <input type="radio" name="avatar_style[hair]" value="{{ $key }}" id="hair-style-{{ $key }}"
                                        {{ ($avatarStyle['hair'] ?? 'Perso-28') === $key ? 'checked' : '' }}
                                        class="sr-only peer"
                                        onchange="submitAvatarForm()"
                                    >
                                    <div class="p-1 rounded-xl border-2 border-transparent peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all hover:bg-gray-50">
                                        <div style="--skin: {{ $avatarColors['skin'] ?? '#f5a57f' }}; --secondary: {{ $avatarColors['secondary'] ?? '#faea2f' }}; --accent: {{ $avatarColors['accent'] ?? '#f2969f' }}; --hair: {{ $avatarColors['hair'] ?? '#2d2d2d' }};">
                                            {!! str_replace('<svg', '<svg style="width:100%;height:auto;max-width:50px"', prefixSvgClasses($svgContent, $pfx)) !!}
                                        </div>
                                        <p class="text-xs text-center font-medium text-gray-700">Cheveux {{ $num }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
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
                                        onchange="submitColorForm()"
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
                                        onchange="submitColorForm()"
                                    >
                                    <label
                                        for="hair-{{ $loop->index }}"
                                        class="w-8 h-8 rounded-full cursor-pointer border border-transparent peer-checked:border-black transition-all"
                                        style="background-color: {{ $color }}"
                                    ></label>
                                @endforeach
                            </div>
                        </div>

                        <input type="hidden" name="avatar_colors[secondary]" value="{{ $avatarColors['secondary'] ?? '#faea2f' }}">

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
                                        onchange="submitColorForm()"
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
        /**
         * Appel AJAX discret pour mettre à jour le style sans rechargement.
         */
        function submitAvatarForm() {
            const face = document.querySelector('input[name="avatar_style[face]"]:checked')?.value || 'Perso-18';
            const features = document.querySelector('input[name="avatar_style[features]"]:checked')?.value || 'Perso-23';
            const hair = document.querySelector('input[name="avatar_style[hair]"]:checked')?.value || 'Perso-28';

            // Appliquer un petit effet de transition
            const preview = document.querySelector('#avatarPreview');
            preview.style.opacity = '0.5';
            preview.style.transition = 'opacity 0.2s';

            fetch('{{ route('avatar.preview') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'text/html',
                },
                body: JSON.stringify({ face, features, hair }),
            })
                .then(res => res.text())
                .then(html => {
                    // Remplacer uniquement le composant avatar dans la preview
                    const temp = document.createElement('div');
                    temp.innerHTML = html;
                    const newAvatar = temp.querySelector('[style*="--skin"]');
                    const oldAvatar = preview.querySelector('[style*="--skin"]');
                    if (newAvatar && oldAvatar) {
                        oldAvatar.replaceWith(newAvatar);
                    } else if (newAvatar) {
                        preview.insertBefore(newAvatar, preview.querySelector('p'));
                    }
                    preview.style.opacity = '1';
                })
                .catch(() => {
                    preview.style.opacity = '1';
                });
        }

        /**
         * Mettre à jour les couleurs dans la prévisualisation et les vignettes
         */
        function submitColorForm() {
            const skinColor = document.querySelector('input[name="avatar_colors[skin]"]:checked')?.value || '#f5a57f';
            const hairColor = document.querySelector('input[name="avatar_colors[hair]"]:checked')?.value || '#2d2d2d';
            const accentColor = document.querySelector('input[name="avatar_colors[accent]"]:checked')?.value || '#f2969f';

            document.querySelectorAll('[style*="--skin"]').forEach(el => {
                el.style.setProperty('--skin', skinColor);
                el.style.setProperty('--hair', hairColor);
                el.style.setProperty('--accent', accentColor);
            });
        }
    </script>
</x-app-layout>
