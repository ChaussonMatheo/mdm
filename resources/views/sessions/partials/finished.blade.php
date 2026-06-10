<div x-show="status === 'closed'" 
     x-data="{ show: false }"
     x-init="setTimeout(() => show = true, 300)"
     class="flex flex-col min-h-[calc(100vh-80px)] relative overflow-hidden"
     style="font-family: 'Figtree', sans-serif;">

    {{-- ==================== HEADER ==================== --}}
    <div class="flex flex-col items-center pt-12 pb-4" x-show="show" x-transition.duration.600ms>
        {{-- Party horn / confetti bomb icon --}}
        <svg class="w-24 h-24 mb-4" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M76 12C76 12 72 28 58 42C44 56 28 60 28 60C28 60 32 48 44 36C56 24 76 12 76 12Z" fill="#E6007E"/>
            <path d="M84 8C84 8 80 24 66 38C52 52 36 56 36 56C36 56 40 44 52 32C64 20 84 8 84 8Z" fill="#FF6BA6" fill-opacity="0.7"/>
            <circle cx="68" cy="28" r="6" fill="#FFD700"/>
            <circle cx="56" cy="40" r="4" fill="#00D4FF"/>
            <circle cx="80" cy="20" r="5" fill="#7F3FBF"/>
            <rect x="72" y="18" width="6" height="6" rx="1" fill="#39FF14" transform="rotate(20 72 18)"/>
            <text x="18" y="82" font-size="14" fill="#E6007E" font-weight="bold">✦</text>
            <text x="60" y="84" font-size="10" fill="#FF6BA6">✦</text>
            <text x="80" y="70" font-size="8" fill="#E6007E" font-weight="bold">✦</text>
            <text x="12" y="28" font-size="12" fill="#FFD700">✦</text>
            <text x="84" y="54" font-size="9" fill="#FFD700">✦</text>
        </svg>

        <h1 class="text-[34px] font-extrabold text-black leading-tight">Bravo !</h1>
        <p class="text-sm tracking-[0.15em] text-black font-medium mt-1">VOUS AVEZ TERMINÉ CETTE SESSION.</p>
    </div>

    {{-- ==================== CENTRAL CARD ==================== --}}
    <div class="flex-grow flex items-start justify-center px-5 mt-2" x-show="show" x-transition.duration.600ms.delay.200ms>
        <div class="relative w-full max-w-sm bg-[#FFDE34] rounded-[28px] px-5 pt-8 pb-4 shadow-md mt-4">
            {{-- Floating badge "M" --}}
            <div class="absolute -top-5 right-4 w-12 h-12 bg-[#6B7C93] rounded-full flex items-center justify-center shadow-md z-10 border-2 border-white">
                <span class="text-white text-xl font-bold">M</span>
            </div>

            {{-- Card title --}}
            <h2 class="text-xl font-extrabold text-black text-center mb-5">Résumé de la session</h2>

            {{-- Rows (using real session modules) --}}
            @php
                $icons = [
                    '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#E6007E" stroke-width="1.5"><rect x="3" y="3" width="8" height="8" rx="1"/><circle cx="16" cy="8" r="5"/><path d="M3 19l6-6M9 13l-6 6" stroke-linecap="round"/></svg>',
                    '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#E6007E" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#E6007E" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3" stroke-linecap="round"/></svg>',
                    '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#E6007E" stroke-width="1.5"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="8" r="3"/><path d="M3 21c.75-3.5 3.5-6 7-6s6.25 2.5 7 6" stroke-linecap="round"/><path d="M14 14c.75-.5 2-1 4-1" stroke-linecap="round"/></svg>',
                ];
                $labels = ['Thème de la discussion', 'Tranche d\'âge', 'Durée', 'Participants'];
                $sessionModules = $session->modules ?? collect();
            @endphp

            @foreach($session->modules->take(4) as $index => $module)
                <div class="flex items-start gap-3 py-2 {{ !$loop->last ? 'border-b border-black/10' : '' }}">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-white/40 flex items-center justify-center">
                        {!! $icons[$index % count($icons)] !!}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-extrabold text-black">{{ $labels[$index] ?? 'Module' }}</p>
                        <p class="text-sm text-gray-700">{{ $module->name }}</p>
                    </div>
                    <div class="flex-shrink-0 text-xs text-gray-500 font-bold mt-0.5">
                        {{ $module->category?->name ?? '' }}
                    </div>
                </div>
            @endforeach

            {{-- If no modules, show placeholder rows --}}
            @if($session->modules->count() == 0)
                @foreach(range(0, 3) as $i)
                    <div class="flex items-start gap-3 py-2 {{ $i < 3 ? 'border-b border-black/10' : '' }}">
                        <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-white/40 flex items-center justify-center">
                            {!! $icons[$i] !!}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-extrabold text-black">{{ $labels[$i] }}</p>
                            <p class="text-sm text-gray-700">{{ ['Gâteau fraise ou pomme ?', '25-34 ans', '15 minutes', '6 participants'][$i] }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- ==================== FOOTER ==================== --}}
    <div class="px-5 pb-6 mt-auto" x-show="show" x-transition.duration.600ms.delay.400ms>
        {{-- Instruction text --}}
        <p class="text-[11px] text-gray-600 text-center leading-relaxed tracking-wide mb-5 max-w-xs mx-auto">
            > POUR LA PREMIÈRE PARTIE ATTRIBUER VOUS DES MINISTÈRES<br>PUIS LES PROCHAINES FOIS DONNER DES NOUVELLES<br>DE VOS MINISTÈRES.
        </p>

        {{-- CTA Button with glitch icons overlay --}}
        <div class="relative w-full max-w-sm mx-auto mb-4">
            <a href="{{ route('ministries.index') }}" 
               class="w-full block bg-black text-white text-center py-4 rounded-[31px] text-lg font-extrabold tracking-wide relative overflow-hidden">
                Attribuer les ministères
            </a>
            {{-- Glitch icon over "e" of "Attribuer" --}}
            <div class="absolute left-[38%] -top-2 w-7 h-7 rounded-full border-2 border-black bg-white flex items-center justify-center -rotate-12 shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="black">
                    <circle cx="12" cy="8" r="3.5"/>
                    <ellipse cx="12" cy="20" rx="7" ry="5"/>
                </svg>
            </div>
            {{-- Glitch icon over "s" of "ministères" --}}
            <div class="absolute right-[20%] -bottom-2 w-7 h-7 rounded-full border-2 border-black bg-white flex items-center justify-center rotate-12 shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="black">
                    <circle cx="12" cy="8" r="3.5"/>
                    <ellipse cx="12" cy="20" rx="7" ry="5"/>
                </svg>
            </div>
        </div>

        {{-- Secondary link --}}
        <a href="{{ route('dashboard') }}" class="block text-center text-sm text-gray-400 hover:text-gray-600 mb-4">
            Quitter
        </a>

        {{-- Bottom cyan dotted/zigzag line --}}
        <div class="flex justify-center gap-1 overflow-hidden">
            @for($i = 0; $i < 30; $i++)
                <div class="w-2 h-2 rounded-full bg-cyan-400 opacity-50" style="margin-top: {{ $i % 2 === 0 ? '0' : '4' }}px;"></div>
            @endfor
        </div>
    </div>
</div>
