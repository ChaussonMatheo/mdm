<x-app-layout>
    <div class="max-w-[393px] mx-auto px-6 py-8 min-h-screen flex flex-col bg-white">


        <!-- Session Info -->
        <div class="mb-10">
            <h1 class="text-[20px] leading-tight text-black roundedfont uppercase mb-2">PRÊT ?</h1>
            <p class="text-[15px] leading-relaxed text-black uppercase font-bold">{{ $session->theme }}</p>
        </div>

        <!-- Code Box -->
        <div class="mb-12">
            <div class="border-2 border-black rounded-[31px] p-8 text-center bg-gray-50">
                <p class="text-[18px] text-gray-500 mb-2 uppercase">Code secret</p>
                <p class="text-[48px] roundedfont text-black leading-none">{{ $session->code }}</p>
            </div>
        </div>

        <!-- Participants -->
        <div id="participants-list" class="flex-grow space-y-4">
            @foreach($session->participants as $participant)
                <div id="participant-{{ $participant->id }}" class="flex items-center justify-between bg-white border border-[#ebecef] rounded-[16px] p-4 transition-all hover:shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center overflow-hidden">
                            <x-avatar-frame :colors="$participant->avatar_colors" size="w-16 h-16" />
                        </div>
                        <span class="text-[15px] font-bold text-black">{{ $participant->id === auth()->id() ? 'Vous' : $participant->name }}</span>
                    </div>
                    <div class="w-4 h-4 rounded-full bg-green-500"></div>
                </div>
            @endforeach

            <div id="placeholders" class="space-y-4">
                @php $remaining = 4 - $session->participants->count(); @endphp
                @for($i = 0; $i < max(0, $remaining); $i++)
                    <div class="flex items-center gap-4 border border-dashed border-[#ebecef] rounded-[16px] p-4 opacity-50">
                        <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="text-[15px] text-gray-400">En attente...</span>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Hidden template for JS to use -->
        <template id="avatar-template">
            <x-avatar-frame :colors="['skin' => 'SKIN_COLOR', 'secondary' => 'SECONDARY_COLOR', 'accent' => 'ACCENT_COLOR', 'hair' => 'HAIR_COLOR']" size="w-16 h-16" />
        </template>

        <!-- Action Button -->
        @if($session->user_id === auth()->id())
            <div class="mt-8">
                <form action="{{ route('sessions.show', $session) }}" method="GET">
                    <button
                        type="submit"
                        class="w-full bg-black hover:bg-gray-900 text-white py-[15px] rounded-[31px] transition-colors flex items-center justify-center gap-2 group"
                    >
                        <span class="text-[20px] roundedfont">Lancer la partie</span>
                    </button>
                </form>
            </div>
        @else
            <div class="mt-8 text-center p-4 bg-gray-50 rounded-[20px] border border-dashed border-[#afafaf]">
                <p class="text-[14px] text-gray-500 italic">En attente que l'organisateur lance la partie...</p>
            </div>
        @endif
    </div>
    <script>
        setTimeout(function (){
            console.log("Echo status : " + (window.Echo ? "initialized" : "failed to initialize"))
            console.log("test")
            // Polyfill for randomUUID in non-secure contexts (HTTP)
            if (!window.crypto.randomUUID) {
                window.crypto.randomUUID = function() {
                    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
                        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                    );
                };
                console.log('Polyfill randomUUID applied');
            }

            console.log('Echo initialization check:', window.Echo ? 'OK' : 'MISSING');
            console.log('Listening on channel: sessions.{{ $session->id }}');

            if (window.Echo) {
                window.Echo.join('sessions.{{ $session->id }}')
                    .here((users) => {
                        console.log('Currently in session:', users);
                    })
                    .joining((user) => {
                        console.log('Participant joining (Presence):', user);
                        addParticipantToList(user);
                    })
                    .leaving((user) => {
                        console.log('Participant leaving (Presence):', user);
                        removeParticipantFromList(user.id);
                    })
                    .listen('.participant.joined', (e) => {
                        console.log('New participant joined event received (Manual):', e);
                        addParticipantToList(e.participant);
                    });

                function addParticipantToList(participant) {
                    const list = document.getElementById('participants-list');
                    const placeholders = document.getElementById('placeholders');

                    if (document.getElementById(`participant-${participant.id}`)) {
                        return;
                    }

                    const newParticipant = document.createElement('div');
                    newParticipant.id = `participant-${participant.id}`;
                    newParticipant.className = 'flex items-center justify-between bg-white border border-[#ebecef] rounded-[16px] p-4 transition-all hover:shadow-sm animate-fade-in-down';

                    const name = participant.name || 'Anonyme';

                    // Get avatar template and replace colors
                    let avatarHtml = document.getElementById('avatar-template').innerHTML;
                    const colors = participant.avatar_colors || {};

                    avatarHtml = avatarHtml
                        .replaceAll('SKIN_COLOR', colors.skin || '#f5a57f')
                        .replaceAll('SECONDARY_COLOR', colors.secondary || '#faea2f')
                        .replaceAll('ACCENT_COLOR', colors.accent || '#f2969f')
                        .replaceAll('HAIR_COLOR', colors.hair || '#2d2d2d');

                    newParticipant.innerHTML = `
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 flex items-center justify-center overflow-hidden">
                                ${avatarHtml}
                            </div>
                            <span class="text-[15px] font-bold text-black">${name}</span>
                        </div>
                        <div class="w-4 h-4 rounded-full bg-green-500"></div>
                    `;

                    if (placeholders) {
                        list.insertBefore(newParticipant, placeholders);
                        if (placeholders.children.length > 0) {
                            placeholders.removeChild(placeholders.lastElementChild);
                        }
                    } else {
                        list.appendChild(newParticipant);
                    }
                }

                function removeParticipantFromList(userId) {
                    const participantElement = document.getElementById(`participant-${userId}`);
                    if (participantElement) {
                        participantElement.style.opacity = '0';
                        participantElement.style.transform = 'translateY(-10px)';

                        setTimeout(() => {
                            participantElement.remove();
                            const placeholders = document.getElementById('placeholders');
                            if (placeholders) {
                                const placeholder = document.createElement('div');
                                placeholder.className = 'flex items-center gap-4 border border-dashed border-[#ebecef] rounded-[16px] p-4 opacity-50';
                                placeholder.innerHTML = `
                                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <span class="text-[15px] text-gray-400">En attente...</span>
                                `;
                                placeholders.appendChild(placeholder);
                            }
                        }, 300);
                    }
                }
            } else {
                console.error('Laravel Echo is not defined! Check if resources/js/app.js is properly compiled.');
            }
        }, 200)
    </script>
</x-app-layout>
