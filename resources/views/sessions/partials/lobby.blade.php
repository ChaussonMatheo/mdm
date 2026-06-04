<div x-show="status === 'preparing'" class="flex flex-col flex-grow">
    <!-- Session Info -->
    <div class="mb-10">
        <h1 class="text-[20px] leading-tight text-black roundedfont uppercase mb-2">PRÊT ?</h1>
        <p class="text-[15px] leading-relaxed text-black uppercase font-bold mb-4">{{ $session->theme }}</p>

    </div>

    <!-- Code Box -->
    <div class="mb-12">
        <div class="border-2 border-black rounded-[31px] p-8 text-center bg-gray-50">
            <p class="text-[18px] text-gray-500 mb-2 uppercase">Code secret</p>
            <p class="text-[48px] roundedfont text-black leading-none">{{ $session->code }}</p>
        </div>
    </div>

    <!-- Participants -->
    <div class="flex-grow space-y-4">
        <template x-for="participant in participants" :key="participant.id">
            <div
                x-data="{ show: false }"
                x-init="$nextTick(() => show = true)"
                x-show="show"
                x-transition:enter="animate-fade-in-down"
                class="flex items-center justify-between bg-white border border-[#ebecef] rounded-[16px] p-4 transition-all hover:shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center overflow-hidden">
                        <!-- avatar pré-rendu côté serveur -->
                        <div class="w-full h-full" x-html="participant.avatar_html"></div>
                    </div>
                    <span class="text-[15px] font-bold text-black" x-text="participant.id === userId ? 'Vous' : participant.name"></span>
                </div>
                <div class="w-4 h-4 rounded-full bg-green-500"></div>
            </div>
        </template>

        <!-- Placeholders -->
        <template x-for="i in Math.max(0, 4 - participants.length)" :key="'placeholder-'+i">
            <div class="flex items-center gap-4 border border-dashed border-[#ebecef] rounded-[16px] p-4 opacity-50">
                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="text-[15px] text-gray-400">En attente...</span>
            </div>
        </template>
    </div>

    <!-- Action Button -->
    <div class="mt-8">
        <template x-if="isOrganizer">
            <button
                @click="startGame"
                class="w-full bg-black hover:bg-gray-900 text-white py-[15px] rounded-[31px] transition-colors flex items-center justify-center gap-2 group"
            >
                <span class="text-[20px] roundedfont">Lancer la partie</span>
            </button>
        </template>
        <template x-if="!isOrganizer">
            <div class="text-center p-4 bg-gray-50 rounded-[20px] border border-dashed border-[#afafaf]">
                <p class="text-[14px] text-gray-500 italic">En attente que l'organisateur lance la partie...</p>
            </div>
        </template>
    </div>
</div>
