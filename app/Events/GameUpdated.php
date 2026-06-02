<?php

namespace App\Events;

use App\Models\GameSessionAnswer;
use App\Models\Session;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Session $session) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('sessions.'.$this->session->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'game.updated';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $data = [
            'session' => $this->session->load('currentModule.category', 'participants'),
            'results' => [],
            'participant_answers' => [],
            'total_answers' => 0,
        ];

        if ($this->session->current_module_id) {
            $data['total_answers'] = GameSessionAnswer::where('game_session_id', $this->session->id)
                ->where('module_id', $this->session->current_module_id)
                ->count();
        }

        if ($this->session->is_showing_results && $this->session->current_module_id) {
            $data['results'] = GameSessionAnswer::where('game_session_id', $this->session->id)
                ->where('module_id', $this->session->current_module_id)
                ->selectRaw('choice, count(*) as count')
                ->groupBy('choice')
                ->pluck('count', 'choice')
                ->toArray();
                
            $data['participant_answers'] = GameSessionAnswer::where('game_session_id', $this->session->id)
                ->where('module_id', $this->session->current_module_id)
                ->pluck('choice', 'user_id')
                ->toArray();
        }

        return $data;
    }
}
