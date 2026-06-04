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

        $styles = $this->getAvailableStyles();

        return view('avatar.customize', [
            'user' => $user,
            'avatarColors' => $user->avatar_colors ?? $this->getDefaultColors(),
            'avatarStyle' => $user->avatar_style ?? 'Perso-28',
            'styles' => $styles,
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
            'avatar_style' => 'nullable|string|max:50',
        ]);

        $data = [
            'avatar_colors' => $validated['avatar_colors'],
        ];

        if (isset($validated['avatar_style'])) {
            $data['avatar_style'] = $validated['avatar_style'];
        }

        auth()->user()->update($data);

        if ($request->has('preview_style')) {
            return redirect()->route('avatar.edit');
        }

        return redirect()->route('avatar.edit')->with('success', 'Avatar personnalisé avec succès !');
    }

    /**
     * Retourner la liste des styles d'avatar disponibles.
     */
    private function getAvailableStyles(): array
    {
        $path = resource_path('svg/visage');
        $files = glob($path . '/Perso-*.svg');
        $styles = [];

        foreach ($files as $file) {
            $basename = pathinfo($file, PATHINFO_FILENAME);
            $num = str_replace('Perso-', '', $basename);

            $styles[$basename] = [
                'name' => "Style {$num}",
                'path' => "svg/visage/{$basename}.svg",
                'preview' => file_get_contents($file),
            ];
        }

        // Trier par numéro
        ksort($styles);

        return $styles;
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
