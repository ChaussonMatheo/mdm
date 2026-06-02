<div x-show="status === 'active' && showingResults" class="flex flex-col flex-grow">
    <!-- Progress Wizard (Results) -->
    <div class="flex gap-2 mb-6">
        <template x-for="(module, index) in modules" :key="module.id">
            <div 
                class="h-1.5 flex-grow rounded-full transition-colors duration-500"
                :class="index <= currentModuleIndex ? 'bg-black' : 'bg-gray-200'"
            ></div>
        </template>
    </div>

    <div class="mb-6 text-center">
        <span class="px-4 py-1 bg-black text-white rounded-full text-[12px] uppercase font-bold" x-text="currentModule?.category?.name"></span>
        <h2 class="mt-4 text-[24px] roundedfont uppercase leading-tight">Résultats</h2>
        <p class="text-[18px] font-bold mt-4" x-text="currentModule?.name"></p>
    </div>

    <!-- Légende des réponses -->
    <div class="grid grid-cols-2 gap-4 mb-8 bg-gray-50 rounded-2xl p-4 border border-black/5">
        <div class="flex items-center gap-3">
            <div class="w-5 h-5 rounded-full bg-green-500 shrink-0 shadow-sm border border-black/10"></div>
            <span class="text-[14px] roundedfont uppercase leading-tight">100% pour</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-5 h-5 rounded-full bg-yellow-400 shrink-0 shadow-sm border border-black/10"></div>
            <span class="text-[14px] roundedfont uppercase leading-tight">Plutôt pour</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-5 h-5 rounded-full bg-orange-500 shrink-0 shadow-sm border border-black/10"></div>
            <span class="text-[14px] roundedfont uppercase leading-tight">Plein de doutes</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-5 h-5 rounded-full bg-red-500 shrink-0 shadow-sm border border-black/10"></div>
            <span class="text-[14px] roundedfont uppercase leading-tight">Je vous suis</span>
        </div>
    </div>

    <!-- Joueurs et pastilles -->
    <div class="flex-grow flex flex-col justify-start">
        <div class="grid grid-cols-3 gap-y-8 gap-x-4">
            <template x-for="participant in participants" :key="participant.id">
                <div class="flex flex-col items-center relative">
                    <div class="relative">
                        <x-avatar-frame class="w-20 h-20" ::style="getAvatarStyle(participant)" />
                        <!-- Pastille de réponse -->
                        <div class="absolute bottom-0 right-0 w-6 h-6 rounded-full border-[3px] border-white shadow-md z-10"
                             :class="{
                                 'bg-green-500': participantAnswers[participant.id] === '100_pour',
                                 'bg-yellow-400': participantAnswers[participant.id] === 'pour',
                                 'bg-orange-500': participantAnswers[participant.id] === 'contre',
                                 'bg-red-500': participantAnswers[participant.id] === '100_contre',
                                 'bg-gray-200': !participantAnswers[participant.id]
                             }"
                             x-show="participantAnswers[participant.id]">
                        </div>
                    </div>
                    <span class="text-[14px] roundedfont mt-2 text-center truncate w-full" x-text="participant.name"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Organizer controls -->
    <template x-if="isOrganizer">
        <div class="mt-8">
            <button
                @click="nextModule"
                class="w-full bg-black hover:bg-gray-900 text-white py-[15px] rounded-[31px] transition-colors flex items-center justify-center gap-2"
            >
                <span class="text-[20px] roundedfont">Suivant</span>
            </button>
        </div>
    </template>
</div>
