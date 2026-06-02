<x-app-layout>
    <div class="max-w-[393px] mx-auto px-6 py-8 min-h-screen flex flex-col bg-white">
        <!-- Header / Logo -->
        <x-slot name="header">
            <p>pas de header</p>
        </x-slot>
        <div class="mt-12 mb-16 flex justify-center">
            <img src="{{ asset('logo/LOGO_MM.svg') }}" alt="MM Logo" class="w-[78px] h-auto">
        </div>

        <!-- Title and Description -->
        <div class="mb-10 space-y-6">
            <h1 class="text-[20px] leading-tight text-black roundedfont uppercase">PRÉPARER</h1>
            <p class="text-[15px] leading-relaxed text-black">
                Écrivez le thème de la discussion et de la décision à prendre, et choisissez parmi les 20 modules ceux qui vous aideront à avancer dans votre décision.
                <span class="text-[#E6066B]">Il est conseillé de choisir au moins un module de chaque famille.</span>
            </p>
        </div>

        <!-- Theme Input Form -->
        <form action="{{ route('sessions.choose-modules') }}" method="GET" id="sessionForm" class="flex-grow flex flex-col gap-10">
            <!-- Search/Theme Input -->
            <div class="relative">
                <input
                    type="text"
                    name="theme"
                    id="theme"
                    placeholder="Quelle décision ?"
                    value="{{ old('theme') }}"
                    class="w-full px-6 py-[21px] border border-[#afafaf] rounded-[31px] text-[18px] placeholder-[#afafaf] focus:outline-none focus:ring-1 focus:ring-[#E6066B] focus:border-[#E6066B]"
                    required
                >
                @error('theme')
                    <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recent Themes Section -->
            <div class="space-y-5">
                <h3 class="text-[20px] roundedfont text-[#afafaf]">Thèmes récents</h3>
                <div class="flex flex-col">
                    @php
                        $recentThemes = [
                            'Tarte à la pomme ou fraise ?',
                            'Tarte à la pomme ou fraise ?',
                            'Tarte à la pomme ou fraise ?',
                            'Tarte à la pomme ou fraise ?',
                            'Tarte à la pomme ou fraise ?',
                        ];
                    @endphp

                    @foreach($recentThemes as $theme)
                        <button type="button"
                                onclick="document.getElementById('theme').value = '{{ $theme }}'; document.getElementById('sessionForm').submit();"
                                class="w-full flex items-center justify-between py-[14px] border-b border-[#ebecef] text-[12px] text-black uppercase text-left transition-colors hover:text-[#E6066B] group">
                            <span>{{ $theme }}</span>
                            <svg class="w-[6px] h-[11px] text-black group-hover:text-[#E6066B]" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L5 5.5L1 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Choose Modules Button -->
            <div class="mt-auto pt-8">
                <button
                    type="submit"
                    class="w-full bg-black hover:bg-gray-900 text-white py-[15px] rounded-[31px] transition-colors flex items-center justify-center gap-2 group"
                >
                    <span class="text-[20px] roundedfont">Choisir modules</span>
                    <svg class="w-[12.5px] h-[25px]" viewBox="0 0 13 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 4.5L10.5 12.5L2.5 20.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>


