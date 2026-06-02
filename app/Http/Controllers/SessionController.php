<?php

namespace App\Http\Controllers;

use App\Events\ParticipantJoined;
use App\Models\ModuleCategory;
use App\Models\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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

        if (!$session) {
            return back()->withErrors(['code' => 'Session non trouvée ou fermée.']);
        }

        // Add user as participant if not already in
        if (!$session->participants()->where('user_id', auth()->id())->exists()) {
            $session->participants()->attach(auth()->id());

            \Illuminate\Support\Facades\Log::info('Broadcasting ParticipantJoined', [
                'session_id' => $session->id,
                'user_id' => auth()->id()
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
        $session->load('participants', 'modules.category');

        return view('sessions.show', compact('session'));
    }

    /**
     * Show the session for editing.
     */
    public function edit(Session $session)
    {
        $this->authorize('update', $session);

        return view('sessions.edit', compact('session'));
    }
}
