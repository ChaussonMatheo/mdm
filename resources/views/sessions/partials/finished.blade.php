<div x-show="status === 'closed'"
     x-data="{ show: false }"
     x-init="setTimeout(() => show = true, 300)"
     class="flex flex-col min-h-[calc(100vh-80px)] relative overflow-hidden"
     style="font-family: 'Figtree', sans-serif;">

    {{-- ==================== HEADER ==================== --}}
    <div class="flex flex-col items-center pt-6 pb-4" x-show="show" x-transition.duration.600ms>
        {{-- Party horn / confetti bomb icon --}}
        <i data-lucide="party-popper" class="w-24 h-24 mb-4 text-[#E6066B]"></i>


        <h1 class="text-[34px] font-extrabold text-black leading-tight">Bravo !</h1>
        <p class="text-sm tracking-[0.15em] text-black font-medium mt-1">VOUS AVEZ TERMINÉ CETTE SESSION.</p>
    </div>

    {{-- ==================== CENTRAL CARD ==================== --}}
    <div class="flex-grow flex items-start justify-center px-5 mt-2" x-show="show" x-transition.duration.600ms.delay.200ms>
        <div class="relative w-full max-w-sm bg-[#FFDE34] rounded-[28px] px-5 pt-8 pb-4 shadow-md mt-4">

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
        <p class="text-[11px] mt-5 text-gray-600 text-center leading-relaxed tracking-wide mb-5 max-w-xs mx-auto">
            POUR LA PREMIÈRE PARTIE ATTRIBUER VOUS DES MINISTÈRES<br>PUIS LES PROCHAINES FOIS DONNER DES NOUVELLES<br>DE VOS MINISTÈRES.
        </p>

        {{-- CTA Button with glitch icons overlay --}}
        <div class="relative w-full max-w-sm mx-auto mb-4">
            <a href="{{ route('ministries.index') }}"
               class="w-full block bg-black text-white text-center py-4 rounded-[31px] text-lg font-extrabold tracking-wide relative overflow-hidden">
                Attribuer les ministères
            </a>
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
