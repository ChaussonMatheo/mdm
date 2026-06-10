
<x-app-layout>
    <div class="py-6 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Les Ministères</h2>
                <p class="text-gray-600 dark:text-gray-400">Attribuez des responsabilités aux membres de votre famille.</p>
            </div>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="bg-[#E6066B] text-white rounded-full px-6 py-2 font-semibold hover:bg-[#CC0E5F] transition-all">
                + Nouveau ministère
            </button>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Liste des ministères -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($ministries as $ministry)
                <div class="bg-white dark:bg-gray-800 rounded-[32px] p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="text-3xl">{{ $ministry->emoji ?? '📜' }}</span>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $ministry->name }}</h3>
                                @if ($ministry->description)
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ministry->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <button onclick="openEditModal({{ $ministry->id }}, '{{ $ministry->name }}', '{{ $ministry->description ?? '' }}', '{{ $ministry->emoji ?? '' }}')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('ministries.destroy', $ministry) }}" method="POST" onsubmit="return confirm('Supprimer ce ministère ?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Titulaire -->
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-4 mt-4">
                        <p class="text-xs font-semibold text-[#E6066B] uppercase tracking-wider mb-2">Titulaire</p>
                        @php $titulaire = $ministry->titulaire->first(); @endphp
                        @if ($titulaire)
                            <div class="flex items-center justify-between py-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#64348B] text-white flex items-center justify-center text-sm font-bold">
                                        {{ strtoupper(substr($titulaire->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $titulaire->name }}</span>
                                </div>
                                <form action="{{ route('ministries.remove-user', [$ministry, $titulaire]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-500 text-xs">Retirer</button>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Aucun titulaire</p>
                        @endif
                    </div>

                    <!-- Suppleants -->
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-3 mt-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Suppleants</p>
                        @if ($ministry->suppleants->isNotEmpty())
                            @foreach ($ministry->suppleants as $suppleant)
                                <div class="flex items-center justify-between py-1">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 flex items-center justify-center text-sm font-bold">
                                            {{ strtoupper(substr($suppleant->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $suppleant->name }}</span>
                                    </div>
                                    <form action="{{ route('ministries.remove-user', [$ministry, $suppleant]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-gray-400 hover:text-red-500 text-xs">Retirer</button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-400 italic">Aucun suppleant</p>
                        @endif
                    </div>

                    <!-- Boutons d'ajout -->
                    <div class="mt-3 flex flex-col gap-2">
                        @if (!$titulaire)
                            <form action="{{ route('ministries.assign', $ministry) }}" method="POST" class="flex gap-2">
                                @csrf
                                <select name="user_id" class="w-full text-sm rounded-full border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 px-3 py-1.5 focus:ring-[#E6066B] focus:border-[#E6066B]">
                                    <option value="">Attribuer titulaire...</option>
                                    @foreach ($familyMembers as $member)
                                        @if (!$ministry->users->contains($member->id))
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-[#E6066B] text-white rounded-full px-4 py-1.5 text-sm font-semibold hover:bg-[#CC0E5F] transition-all whitespace-nowrap">
                                    Ajouter
                                </button>
                            </form>
                        @endif
                        @if ($ministry->suppleants->count() < 3)
                            <form action="{{ route('ministries.assign-suppleant', $ministry) }}" method="POST" class="flex gap-2">
                                @csrf
                                <select name="user_id" class="w-full text-sm rounded-full border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 px-3 py-1.5 focus:ring-[#E6066B] focus:border-[#E6066B]">
                                    <option value="">Ajouter suppleant...</option>
                                    @foreach ($familyMembers as $member)
                                        @if (!$ministry->users->contains($member->id))
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-[#64348B] text-white rounded-full px-4 py-1.5 text-sm font-semibold hover:bg-[#52297A] transition-all whitespace-nowrap">
                                    Ajouter
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                    <p class="text-5xl mb-4">🏛️</p>
                    <p class="text-lg font-medium">Aucun ministere pour le moment</p>
                    <p class="text-sm">Cree votre premier ministere pour commencer a attribuer des responsabilites.</p>
                </div>
            @endforelse
        </div>

        <!-- Modal Création -->
        <div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white dark:bg-gray-800 rounded-[32px] p-6 w-full max-w-md mx-4 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Nouveau ministère</h3>
                    <button onclick="document.getElementById('createModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ route('ministries.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="create-name" value="Nom du ministère" />
                        <x-text-input id="create-name" name="name" class="mt-1 block w-full" placeholder="Ministre de l'Économie" required />
                    </div>
                    <div>
                        <x-input-label for="create-emoji" value="Emoji" />
                        <x-text-input id="create-emoji" name="emoji" class="mt-1 block w-full" placeholder="💰" maxlength="10" />
                    </div>
                    <div>
                        <x-input-label for="create-description" value="Description (optionnelle)" />
                        <textarea id="create-description" name="description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl focus:ring-[#E6066B] focus:border-[#E6066B]" placeholder="Ce ministre s'occupe de l'argent..."></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="px-4 py-2 text-sm rounded-full border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Annuler</button>
                        <x-primary-button class="bg-[#E6066B] hover:bg-[#CC0E5F]">Créer</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Édition -->
        <div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white dark:bg-gray-800 rounded-[32px] p-6 w-full max-w-md mx-4 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Modifier le ministère</h3>
                    <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="edit-name" value="Nom du ministère" />
                        <x-text-input id="edit-name" name="name" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="edit-emoji" value="Emoji" />
                        <x-text-input id="edit-emoji" name="emoji" class="mt-1 block w-full" maxlength="10" />
                    </div>
                    <div>
                        <x-input-label for="edit-description" value="Description (optionnelle)" />
                        <textarea id="edit-description" name="description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl focus:ring-[#E6066B] focus:border-[#E6066B]"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 text-sm rounded-full border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Annuler</button>
                        <x-primary-button class="bg-[#E6066B] hover:bg-[#CC0E5F]">Enregistrer</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, name, description, emoji) {
            const form = document.getElementById('editForm');
            form.action = '/ministries/' + id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-emoji').value = emoji;
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
