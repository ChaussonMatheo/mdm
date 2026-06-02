<x-app-layout>
    <div
        x-data="gameSession({
            sessionId: {{ $session->id }},
            userId: {{ auth()->id() }},
            isOrganizer: {{ $session->user_id === auth()->id() ? 'true' : 'false' }},
            initialStatus: '{{ $session->status }}',
            initialShowingResults: {{ $session->is_showing_results ? 'true' : 'false' }},
            initialModule: {{ $session->currentModule ? json_encode($session->currentModule->load('category')) : 'null' }},
            initialHasAnswered: {{ $hasAnswered ? 'true' : 'false' }},
            participants: {{ json_encode($session->participants) }},
            results: {{ json_encode($results) }},
            participantAnswers: {{ json_encode($participantAnswers ?? []) }},
            initialTotalAnswers: {{ $session->current_module_id ? \App\Models\GameSessionAnswer::where('game_session_id', $session->id)->where('module_id', $session->current_module_id)->count() : 0 }},
            modules: {{ json_encode($session->modules) }},
            initialModuleIndex: {{ $session->current_module_id ? array_search($session->current_module_id, $session->modules->pluck('id')->toArray()) : 0 }}
        })"
        class="max-w-[393px] mx-auto px-6 py-8 min-h-screen flex flex-col bg-white"
    >
        @include('sessions.partials.lobby')
        @include('sessions.partials.question')
        @include('sessions.partials.results')
        @include('sessions.partials.finished')
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('gameSession', (config) => ({
                sessionId: config.sessionId,
                userId: config.userId,
                isOrganizer: config.isOrganizer,
                status: config.initialStatus,
                showingResults: config.initialShowingResults,
                currentModule: config.initialModule,
                hasAnswered: config.initialHasAnswered,
                participants: config.participants,
                participantAnswers: config.participantAnswers || {},
                totalAnswers: config.initialTotalAnswers || 0,
                selectedChoice: null,
                modules: config.modules || [],
                currentModuleIndex: config.initialModuleIndex || 0,

                get everyoneHasAnswered() {
                    return this.totalAnswers >= this.participants.length && this.participants.length > 0;
                },

                getAvatarStyle(participant) {
                    let colors = participant.avatar_colors;
                    if (typeof colors === 'string') {
                        try {
                            colors = JSON.parse(colors);
                        } catch (e) {
                            colors = {};
                        }
                    }
                    colors = colors || {};
                    return `--skin: ${colors.skin || '#f5a57f'}; --secondary: ${colors.secondary || '#faea2f'}; --accent: ${colors.accent || '#f2969f'}; --hair: ${colors.hair || '#2d2d2d'};`;
                },

                init() {
                    console.log('Game initialized on channel: sessions.' + this.sessionId);

                    if (window.Echo) {
                        window.Echo.join(`sessions.${this.sessionId}`)
                            .here((users) => {
                                console.log('Current participants:', users);
                                this.participants = users;
                            })
                            .joining((user) => {
                                console.log('User joining:', user);
                                if (!this.participants.find(p => p.id === user.id)) {
                                    this.participants.push(user);
                                }
                            })
                            .leaving((user) => {
                                console.log('User leaving:', user);
                                this.participants = this.participants.filter(p => p.id !== user.id);
                            })
                            .listen('.game.updated', (e) => {
                                console.log('Game updated received:', e);
                                
                                const isNewModule = this.currentModule && e.session.current_module && e.session.current_module.id !== this.currentModule.id;
                                
                                this.status = e.session.status;
                                this.showingResults = e.session.is_showing_results;
                                this.currentModule = e.session.current_module;
                                
                                if (e.results) {
                                    this.results = e.results;
                                }

                                if (e.participant_answers) {
                                    this.participantAnswers = e.participant_answers;
                                }

                                if (typeof e.total_answers !== 'undefined') {
                                    this.totalAnswers = e.total_answers;
                                }

                                if (isNewModule) {
                                    this.hasAnswered = false; // Reset for new question
                                    this.selectedChoice = null; // Reset selection
                                }

                                if (this.currentModule) {
                                    this.currentModuleIndex = this.modules.findIndex(m => m.id === this.currentModule.id);
                                }
                            });
                    }
                },

                async startGame() {
                    try {
                        await fetch(`/sessions/${this.sessionId}/start`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                    } catch (e) {
                        console.error('Failed to start game', e);
                    }
                },

                async confirmAnswer() {
                    if (!this.selectedChoice) return;
                    
                    const choice = this.selectedChoice;
                    this.hasAnswered = true;
                    
                    try {
                        const response = await fetch(`/sessions/${this.sessionId}/answer`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ choice })
                        });
                        
                        if (!response.ok) throw new Error('Failed to submit');
                        
                        // Local update to see progress
                        this.results[choice] = (this.results[choice] || 0) + 1;
                    } catch (e) {
                        this.hasAnswered = false;
                        alert('Erreur lors de l\'envoi de votre réponse.');
                    }
                },

                async showResultsNow() {
                    try {
                        await fetch(`/sessions/${this.sessionId}/results`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                    } catch (e) {
                        console.error('Failed to show results', e);
                    }
                },

                async nextModule() {
                    try {
                        await fetch(`/sessions/${this.sessionId}/next`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                    } catch (e) {
                        console.error('Failed to move to next module', e);
                    }
                }
            }));
        });
    </script>
</x-app-layout>
