<div x-show="status === 'active' && !showingResults" class="flex flex-col flex-grow">


    <!-- Question Header -->
    <div class="mb-6 text-center">
        <span class="px-4 py-1 bg-black text-white rounded-full text-[12px] uppercase font-bold" x-text="currentModule?.category?.name"></span>
        <!-- Progress Wizard (Game) -->
        <div class="flex px-4 py-4 gap-2">
            <template x-for="(module, index) in modules" :key="module.id">
                <div
                    class="h-1.5 flex-grow rounded-full transition-colors duration-500"
                    :class="index <= currentModuleIndex ? 'bg-black' : 'bg-gray-200'"
                ></div>
            </template>
        </div>
        <h2 class="text-[24px] roundedfont uppercase leading-tight" x-text="currentModule?.name"></h2>
    </div>

    <div class="flex-grow flex flex-col justify-center">
        <template x-if="!hasAnswered">
            <div class="flex flex-col items-center justify-center gap-8">
                <div class="grid grid-cols-2 gap-6 w-full max-w-sm">
                    <!-- 100% POUR (Vert) -->
                    <button
                        @click="selectedChoice = '100_pour'"
                        :class="selectedChoice === '100_pour' ? 'ring-4 ring-offset-2 ring-black scale-95' : ''"
                        class="aspect-square bg-green-500 text-white rounded-full flex items-center justify-center transition-all hover:shadow-lg active:scale-95"
                    >
                        <div class="text-center">
                            <div class="text-[24px] roundedfont font-bold">100%</div>
                            <div class="text-[18px] roundedfont">pour</div>
                        </div>
                    </button>

                    <!-- POUR (Jaune lime) -->
                    <button
                        @click="selectedChoice = 'pour'"
                        :class="selectedChoice === 'pour' ? 'ring-4 ring-offset-2 ring-black scale-95' : ''"
                        class="aspect-square bg-yellow-400 text-black rounded-full flex items-center justify-center transition-all hover:shadow-lg active:scale-95"
                    >
                        <div class="text-center">
                            <div class="text-[24px] roundedfont font-bold">Plutôt</div>
                            <div class="text-[18px] roundedfont">pour</div>
                        </div>
                    </button>

                    <!-- CONTRE (Orange) -->
                    <button
                        @click="selectedChoice = 'contre'"
                        :class="selectedChoice === 'contre' ? 'ring-4 ring-offset-2 ring-black scale-95' : ''"
                        class="aspect-square bg-orange-500 text-white rounded-full flex items-center justify-center transition-all hover:shadow-lg active:scale-95"
                    >
                        <div class="text-center">
                            <div class="text-[24px] roundedfont font-bold">Plein de</div>
                            <div class="text-[18px] roundedfont">doutes</div>
                        </div>
                    </button>

                    <!-- 100% CONTRE (Rouge) -->
                    <button
                        @click="selectedChoice = '100_contre'"
                        :class="selectedChoice === '100_contre' ? 'ring-4 ring-offset-2 ring-black scale-95' : ''"
                        class="aspect-square bg-red-500 text-white rounded-full flex items-center justify-center transition-all hover:shadow-lg active:scale-95"
                    >
                        <div class="text-center">
                            <div class="text-[24px] roundedfont font-bold">Je vous</div>
                            <div class="text-[18px] roundedfont">suis</div>
                        </div>
                    </button>
                </div>

                <div class="w-full max-w-sm">
                    <button
                        @click="confirmAnswer"
                        :disabled="!selectedChoice"
                        :class="!selectedChoice ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-900'"
                        class="w-full bg-black text-white py-[15px] rounded-[31px] transition-colors flex items-center justify-center gap-2"
                    >
                        <span class="text-[20px] roundedfont">Confirmer mon vote</span>
                    </button>
                </div>
            </div>
        </template>

        <template x-if="hasAnswered">
            <div class="text-center space-y-6">
                <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="text-[20px] font-bold">Vote enregistré !</p>
                <p class="text-gray-500" x-text="'En attente des autres participants... (' + totalAnswers + '/' + participants.length + ')'"></p>
            </div>
        </template>
    </div>

    <!-- Organizer controls -->
    <template x-if="isOrganizer">
        <div class="mt-8">
            <button
                @click="showResultsNow"
                :disabled="!everyoneHasAnswered"
                :class="!everyoneHasAnswered ? 'opacity-50 cursor-not-allowed bg-gray-400' : 'bg-black hover:bg-gray-900'"
                class="w-full text-white py-[15px] rounded-[31px] transition-colors flex items-center justify-center gap-2"
            >
                <span class="text-[20px] roundedfont">Voir les résultats</span>
                <template x-if="!everyoneHasAnswered">
                    <span class="text-[12px] opacity-75" x-text="'(' + totalAnswers + '/' + participants.length + ')'"></span>
                </template>
            </button>
        </div>
    </template>
</div>
