<x-app-layout>
    <x-slot name="header">
        <p>pas de header</p>
    </x-slot>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="mb-12 flex justify-center">
            <img src="{{ asset('logo/LOGO_MM.svg') }}" alt="MM Logo" class="w-20 h-auto">
        </div>
        <!-- Title and Description -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-3">Mes modules</h1>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                Choisissez vos familles de modules préconisés : au moins 1 par famille
            </p>
        </div>

        <form action="{{ route('sessions.store') }}" method="POST" id="modulesForm" class="space-y-4">
            @csrf
            <input type="hidden" name="theme" value="{{ $theme }}">

            <!-- Categories as expandable cards -->
            <div class="space-y-3">
                @foreach($categories as $category)
                    <div class="category-item">
                        <!-- Category Header (clickable) -->
                        <button
                            type="button"
                            onclick="toggleCategory({{ $category->id }})"
                            class="w-full text-white rounded-2xl px-6 py-4 flex items-center justify-between transition-all hover:shadow-lg"
                            style="background-color: {{ $category->color }};"
                        >
                            <div class="text-left">
                                <h3 class="text-lg font-bold">{{ $category->name }}</h3>
                                <p class="text-sm opacity-90">{{ $category->modules->count() }} Modules</p>
                            </div>
                            <span class="text-2xl chevron-icon">›</span>
                        </button>

                        <!-- Modules list (hidden by default) -->
                        <div id="category-{{ $category->id }}" class="hidden bg-gray-100 dark:bg-gray-800 rounded-b-2xl p-4 space-y-2 border-t-2" style="border-color: {{ $category->color }};">
                            <div class="space-y-3">
                                @foreach($category->modules as $module)
                                    <label class="flex items-center p-3 bg-white dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                        <input
                                            type="checkbox"
                                            name="modules[]"
                                            value="{{ $module->id }}"
                                            class="w-5 h-5 rounded focus:ring-2"
                                            style="accent-color: {{ $module->color }};"
                                            data-category="{{ $category->id }}"
                                        >
                                        <div class="ml-3">
                                            <div class="font-semibold text-gray-900 dark:text-white">{{ $module->name }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @error('modules')
                <p class="text-red-500 text-sm mt-4 text-center">{{ $message }}</p>
            @enderror

            <!-- Submit Button -->
            <div class="flex justify-center pt-8">
                <button
                    type="submit"
                    class="w-full bg-black hover:bg-gray-900 text-white font-bold py-4 rounded-full transition-colors flex items-center justify-center gap-2"
                >
                    Continuer
                    <span class="text-lg">›</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleCategory(categoryId) {
            const element = document.getElementById(`category-${categoryId}`);
            const button = event.currentTarget;

            element.classList.toggle('hidden');

            // Rotate chevron
            const chevron = button.querySelector('.chevron-icon');
            if (element.classList.contains('hidden')) {
                chevron.style.transform = 'rotate(0deg)';
            } else {
                chevron.style.transform = 'rotate(90deg)';
            }
        }

        // Listener pour garder track des catégories validées
        document.getElementById('modulesForm').addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('input[name="modules[]"]:checked');
            if (checked.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner au moins un module par catégorie');
            }
        });
    </script>
</x-app-layout>

