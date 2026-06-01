<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{
    /**
     * Afficher la page de personnalisation d'avatar.
     */
    public function edit()
    {
        $user = auth()->user();

        return view('avatar.customize', [
            'user' => $user,
            'avatarColors' => $user->avatar_colors ?? $this->getDefaultColors(),
        ]);
    }

    /**
     * Mettre à jour l'avatar de l'utilisateur.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'avatar_colors' => 'required|array',
            'avatar_colors.skin' => 'required|string|regex:/^#[0-9a-fA-F]{6}$/',
            'avatar_colors.hair' => 'required|string|regex:/^#[0-9a-fA-F]{6}$/',
            'avatar_colors.secondary' => 'required|string|regex:/^#[0-9a-fA-F]{6}$/',
            'avatar_colors.accent' => 'required|string|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('avatar.edit')->with('success', 'Avatar personnalisé avec succès !');
    }

    /**
     * Retourner les couleurs par défaut.
     */
    private function getDefaultColors(): array
    {
        return [
            'skin' => '#f5a57f',
            'hair' => '#2d2d2d',
            'secondary' => '#faea2f',
            'accent' => '#f2969f',
        ];
    }
}
