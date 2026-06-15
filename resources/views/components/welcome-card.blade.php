@props(['user' => auth()->user()])

@php
    // Ensure avatar_style is an array (it might be corrupted if DB column is still string)
    $style = $user->avatar_style;
    if (!is_array($style)) {
        $decoded = json_decode($style, true);
        $style = is_array($decoded) ? $decoded : ['face' => 'Perso-18', 'features' => 'Perso-23', 'hair' => 'Perso-28'];
    }
@endphp

<div class="mt-4 w-full  mx-auto bg-[#FAEA2F] rounded-[32px] px-8 sm:px-12 text-center">
    <!-- Avatar Circle -->
    <div class="flex justify-center">
        <div class="w-64 h-52  flex items-center justify-center ">
            <x-avatar-frame :colors="$user->avatar_colors" :style="$style" size="w-58 h-full" />
        </div>
    </div>

    <!-- Greeting -->
    <h2 class="text-2xl sm:text-3xl font-black mt-6 text-gray-900 mb-4">
        Bonjour, <span class="text-[#E6066B]">{{ $user->name }}</span> !
    </h2>

    <!-- Button -->
    <div class="mb-6">
        <a href="{{ route('avatar.edit') }}" class="inline-flex items-center gap-2 bg-black text-white px-6 py-2 rounded-full font-bold hover:bg-gray-800 transition-colors">
            Modifier
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <!-- Description -->
    <p class="text-sm sm:text-base pb-2 text-gray-800 font-medium leading-relaxed">
        Prêt à débloquer et arbitrer de vrais sujets de discussion en famille ?
    </p>
</div>

