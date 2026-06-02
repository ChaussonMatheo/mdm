<x-app-layout>
    <div class="max-w-[393px] mx-auto px-6 py-8 min-h-screen flex flex-col bg-white">
        <!-- Header -->
        <div class="mt-8 mb-12 flex items-center justify-between">
            <a href="{{ route('sessions.create') }}" class="p-2">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <img src="{{ asset('logo/LOGO_MM.svg') }}" alt="MM Logo" class="w-[50px] h-auto">
            <div class="w-10"></div> <!-- Spacer -->
        </div>

        <!-- Title and Description -->
        <div class="mb-10 space-y-4">
            <h1 class="text-[20px] leading-tight text-black roundedfont uppercase">MES MODULES</h1>
            <p class="text-[15px] leading-relaxed text-black">
                Choisissez vos familles de modules préconisés : 
                <span class="text-[#E6066B]">au moins 1 par famille</span>
            </p>
        </div>

        <form action="{{ route('sessions.store') }}" method="POST" id="modulesForm" class="flex-grow flex flex-col gap-6">
            @csrf
            <input type="hidden" name="theme" value="{{ $theme }}">

            <!-- Categories as expandable cards -->
            <div class="space-y-4">
                @foreach($categories as $category)
                    <div class="category-item flex flex-col" x-data="{ open: false }">
                        <!-- Category Header -->
                        <button
                            type="button"
                            @click="open = !open"
                            class="w-full text-white rounded-[31px] px-8 py-6 flex items-center justify-between transition-all"
                            :class="open ? 'rounded-b-none' : ''"
                            style="background-color: {{ $category->color }};"
                        >
                            <div class="text-left">
                                <h3 class="text-[20px] roundedfont uppercase leading-tight">{{ $category->name }}</h3>
                                <p class="text-[15px] opacity-90 italic">{{ $category->modules->count() }} Modules</p>
                            </div>
                            <svg class="w-6 h-6 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <!-- Modules list -->
                        <div x-show="open" 
                             x-collapse
                             class="bg-gray-50 border-x border-b rounded-b-[31px] p-6 space-y-4"
                             style="border-color: {{ $category->color }};">
                            <div class="space-y-4">
                                @foreach($category->modules as $module)
                                    <label class="flex items-center gap-4 cursor-pointer group">
                                        <div class="relative">
                                            <input
                                                type="checkbox"
                                                name="modules[]"
                                                value="{{ $module->id }}"
                                                class="w-6 h-6 rounded-md border-gray-300 text-black focus:ring-black"
                                                style="accent-color: black;"
                                            >
                                        </div>
                                        <div class="flex-grow">
                                            <div class="text-[15px] font-bold text-gray-800 group-hover:text-black transition-colors">{{ $module->name }}</div>
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
            <div class="mt-auto pt-8">
                <button
                    type="submit"
                    class="w-full bg-black hover:bg-gray-900 text-white py-[15px] rounded-[31px] transition-colors flex items-center justify-center gap-2 group"
                >
                    <span class="text-[20px] roundedfont">Continuer</span>
                    <svg class="w-[12.5px] h-[25px]" viewBox="0 0 13 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 4.5L10.5 12.5L2.5 20.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

