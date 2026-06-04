<?php

namespace App\Http\Controllers;

use App\Models\Ministry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MinistryController extends Controller
{
    /**
     * Display all ministries for the user's family.
     */
    public function index(): View
    {
        $family = Auth::user()->family;

        if (! $family) {
            abort(403, 'Vous devez appartenir à une famille pour gérer les ministères.');
        }

        $ministries = $family->ministries()->with('users')->get();
        $familyMembers = $family->users;

        return view('ministries.index', compact('ministries', 'familyMembers'));
    }

    /**
     * Store a newly created ministry.
     */
    public function store(Request $request): RedirectResponse
    {
        $family = Auth::user()->family;

        if (! $family) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'emoji' => ['nullable', 'string', 'max:10'],
        ]);

        $family->ministries()->create($validated);

        return redirect()->route('ministries.index')->with('status', 'Ministère créé avec succès.');
    }

    /**
     * Update the specified ministry.
     */
    public function update(Request $request, Ministry $ministry): RedirectResponse
    {
        $this->authorize('modify', $ministry);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'emoji' => ['nullable', 'string', 'max:10'],
        ]);

        $ministry->update($validated);

        return redirect()->route('ministries.index')->with('status', 'Ministère mis à jour avec succès.');
    }

    /**
     * Remove the specified ministry.
     */
    public function destroy(Ministry $ministry): RedirectResponse
    {
        $this->authorize('modify', $ministry);

        $ministry->delete();

        return redirect()->route('ministries.index')->with('status', 'Ministère supprimé avec succès.');
    }

    /**
     * Assign a user to a ministry.
     */
    public function assignUser(Request $request, Ministry $ministry): RedirectResponse
    {
        $this->authorize('modify', $ministry);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);

        // Ensure the user belongs to the same family
        if ($user->family_id !== $ministry->family_id) {
            return back()->withErrors(['user_id' => 'Cet utilisateur n\'appartient pas à votre famille.']);
        }

        // Check if this user already has this ministry
        if ($ministry->users()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['user_id' => 'Cet utilisateur a déjà ce ministère.']);
        }

        $ministry->users()->attach($user);

        return redirect()->route('ministries.index')->with('status', 'Ministère attribué avec succès.');
    }

    /**
     * Remove a user from a ministry.
     */
    public function removeUser(Ministry $ministry, User $user): RedirectResponse
    {
        $this->authorize('modify', $ministry);

        $ministry->users()->detach($user);

        return redirect()->route('ministries.index')->with('status', 'Ministère retiré avec succès.');
    }
}
