@props(['user' => auth()->user()])

<div class="mt-4 w-full  mx-auto bg-[#FAEA2F] rounded-[32px] px-8 sm:px-12 text-center">
    <!-- Avatar Circle -->
    <div class="flex justify-center">
        <div class="w-64 h-52  flex items-center justify-center ">
            <x-avatar-frame :colors="$user->avatar_colors" :style="$user->avatar_style" size="w-58 h-full" />
        </div>
    </div>

    <!-- Greeting -->
    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mb-4">
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

