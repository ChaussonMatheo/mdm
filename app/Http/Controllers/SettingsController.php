<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        $user = Auth::user()->load('family');

        // Get active game sessions (status = 'preparing' or 'active')
        $activeSessions = Session::whereIn('status', ['preparing', 'active'])
            ->with(['user', 'participants'])
            ->latest()
            ->get();

        return view('settings.index', compact('user', 'activeSessions'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $request->user()->fill($validated);
        $request->user()->save();

        return Redirect::route('settings.index')->with('status', 'profile-updated');
    }

    /**
     * Join a family via unique code.
     */
    public function joinFamily(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:10'],
        ]);

        $family = Family::where('unique_code', strtoupper($validated['code']))->first();

        if (! $family) {
            return back()->withErrors(['code' => 'Code famille invalide.']);
        }

        $request->user()->update(['family_id' => $family->id]);

        return Redirect::route('settings.index')->with('status', 'family-joined');
    }
    /**
     * Leave the current family.
     */
    public function leaveFamily(Request $request)
    {
        $request->user()->update(['family_id' => null]);

        return Redirect::route('settings.index')->with('status', 'family-left');
    }

    /**
     * Join a game session.
     */
    public function joinSession(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $session = Session::where('code', $validated['code'])
            ->whereIn('status', ['preparing', 'active'])
            ->first();

        if (! $session) {
            return back()->withErrors(['session_code' => 'Session non trouvée ou fermée.']);
        }

        // Add user as participant if not already in
        if (! $session->participants()->where('user_id', auth()->id())->exists()) {
            $session->participants()->attach(auth()->id());
        }

        return redirect()->route('sessions.show', $session);
    }
}
