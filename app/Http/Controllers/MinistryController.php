<?php

namespace App\Http\Controllers;

use App\Models\Ministry;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MinistryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display all ministries for the user's family.
     */
    public function index(): View
    {
        $family = Auth::user()->family;

        if (! $family) {
            abort(403, 'Vous devez appartenir à une famille pour gérer les ministères.');
        }

        $ministries = $family->ministries()->with('users', 'titulaire', 'suppleants')->get();
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
     * Assign a user as titulaire to a ministry.
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

        // If no titulaire yet, assign as titulaire
        $hasTitulaire = $ministry->titulaire()->exists();
        $role = $hasTitulaire ? 'suppleant' : 'titulaire';

        $ministry->users()->attach($user, ['role' => $role]);

        $message = $role === 'titulaire'
            ? 'Ministère attribué avec succès.'
            : 'Suppléant ajouté avec succès.';

        return redirect()->route('ministries.index')->with('status', $message);
    }

    /**
     * Assign a substitute (suppleant) to a ministry.
     */
    public function assignSuppleant(Request $request, Ministry $ministry): RedirectResponse
    {
        $this->authorize('modify', $ministry);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);

        if ($user->family_id !== $ministry->family_id) {
            return back()->withErrors(['user_id' => 'Cet utilisateur n\'appartient pas à votre famille.']);
        }

        if ($ministry->users()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['user_id' => 'Cet utilisateur a déjà ce ministère.']);
        }

        $ministry->users()->attach($user, ['role' => 'suppleant']);

        return redirect()->route('ministries.index')->with('status', 'Suppléant ajouté avec succès.');
    }

    /**
     * Remove a user from a ministry.
     */
    public function removeUser(Ministry $ministry, User $user): RedirectResponse
    {
        $this->authorize('modify', $ministry);

        $role = $ministry->users()->where('user_id', $user->id)->first()?->pivot?->role;

        $ministry->users()->detach($user);

        // If we removed the titulaire, promote the first suppleant to titulaire
        if ($role === 'titulaire') {
            $firstSuppleant = $ministry->suppleants()->first();
            if ($firstSuppleant) {
                $ministry->users()->updateExistingPivot($firstSuppleant->id, ['role' => 'titulaire']);
            }
        }

        return redirect()->route('ministries.index')->with('status', 'Ministère retiré avec succès.');
    }
}
