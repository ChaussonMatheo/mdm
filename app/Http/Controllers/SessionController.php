<?php

namespace App\Http\Controllers;

use App\Events\GameUpdated;
use App\Events\ParticipantJoined;
use App\Models\GameSessionAnswer;
use App\Models\ModuleCategory;
use App\Models\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show the form for creating a new session (Step 1).
     */
    public function create()
    {
        $categories = ModuleCategory::with('modules')->get();

        return view('sessions.create', compact('categories'));
    }

    /**
     * Show the form for choosing modules (Step 2).
     */
    public function chooseModules(Request $request)
    {
        $theme = $request->query('theme');

        if (! $theme) {
            return redirect()->route('sessions.create')->with('error', 'Theme is required');
        }

        $categories = ModuleCategory::with('modules')->get();

        return view('sessions.choose-modules', compact('categories', 'theme'));
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|string|max:255',
            'modules' => 'required|array|min:4',
            'modules.*' => 'exists:modules,id',
        ]);

        $session = Session::create([
            'user_id' => auth()->id(),
            'theme' => $validated['theme'],
            'code' => Session::generateCode(),
        ]);

        $session->modules()->attach($validated['modules']);

        // The creator is the first participant
        $session->participants()->attach(auth()->id());

        return redirect()->route('sessions.show', $session)->with('message', 'Session created successfully.');
    }

    /**
     * Join an existing session.
     */
    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $session = Session::where('code', $request->code)
            ->where('status', '!=', 'closed')
            ->first();

        if (! $session) {
            return back()->withErrors(['code' => 'Session non trouvée ou fermée.']);
        }

        // Add user as participant if not already in
        if (! $session->participants()->where('user_id', auth()->id())->exists()) {
            $session->participants()->attach(auth()->id());

            Log::info('Broadcasting ParticipantJoined', [
                'session_id' => $session->id,
                'user_id' => auth()->id(),
            ]);

            // Dispatch real-time event
            broadcast(new ParticipantJoined($session, auth()->user()));
        }

        return redirect()->route('sessions.show', $session);
    }

    /**
     * Display the session lobby/waiting room.
     */
    public function show(Session $session)
    {
        $session->load(['participants', 'modules.category', 'currentModule.category']);

        if ($session->is_showing_results) {
            $results = GameSessionAnswer::where('game_session_id', $session->id)
                ->where('module_id', $session->current_module_id)
                ->selectRaw('choice, count(*) as count')
                ->groupBy('choice')
                ->pluck('count', 'choice')
                ->toArray();
                
            $participantAnswers = GameSessionAnswer::where('game_session_id', $session->id)
                ->where('module_id', $session->current_module_id)
                ->pluck('choice', 'user_id')
                ->toArray();
        } else {
            $results = [];
            $participantAnswers = [];
        }

        $hasAnswered = $session->current_module_id
            ? $session->answers()->where('user_id', auth()->id())->where('module_id', $session->current_module_id)->exists()
            : false;

        return view('sessions.show', compact('session', 'results', 'participantAnswers', 'hasAnswered'));
    }

    /**
     * Start the game.
     */
    public function start(Session $session)
    {
        $this->authorize('update', $session);

        if ($session->status !== 'preparing') {
            return back();
        }

        $firstModule = $session->modules()->first();

        $session->update([
            'status' => 'active',
            'current_module_id' => $firstModule->id,
            'is_showing_results' => false,
        ]);

        broadcast(new GameUpdated($session));

        return back();
    }

    /**
     * Record an answer.
     */
    public function answer(Request $request, Session $session)
    {
        $validated = $request->validate([
            'choice' => 'required|string|in:100_pour,pour,contre,100_contre',
        ]);

        if ($session->status !== 'active' || $session->is_showing_results) {
            return response()->json(['error' => 'La session n\'est pas active.'], 403);
        }

        GameSessionAnswer::updateOrCreate(
            [
                'game_session_id' => $session->id,
                'module_id' => $session->current_module_id,
                'user_id' => auth()->id(),
            ],
            [
                'choice' => $validated['choice'],
            ]
        );

        broadcast(new GameUpdated($session));

        return response()->json(['success' => true]);
    }

    /**
     * Show results for the current module.
     */
    public function showResults(Session $session)
    {
        $this->authorize('update', $session);

        $session->update(['is_showing_results' => true]);

        broadcast(new GameUpdated($session));

        return back();
    }

    /**
     * Move to the next module.
     */
    public function next(Session $session)
    {
        $this->authorize('update', $session);

        $currentModuleId = $session->current_module_id;
        $modules = $session->modules->pluck('id')->toArray();
        $currentIndex = array_search($currentModuleId, $modules);

        if ($currentIndex !== false && isset($modules[$currentIndex + 1])) {
            $session->update([
                'current_module_id' => $modules[$currentIndex + 1],
                'is_showing_results' => false,
            ]);
        } else {
            $session->update([
                'status' => 'closed',
                'current_module_id' => null,
                'is_showing_results' => false,
            ]);
        }

        broadcast(new GameUpdated($session));

        return back();
    }
}
