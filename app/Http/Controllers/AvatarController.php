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

        $avatarStyle = $user->avatar_style ?? json_encode([
            'face' => 'Perso-18',
            'features' => 'Perso-23',
            'hair' => 'Perso-28',
        ]);
        $avatarStyle = is_string($avatarStyle) ? json_decode($avatarStyle, true) : $avatarStyle;

        return view('avatar.customize', [
            'user' => $user,
            'avatarColors' => $user->avatar_colors ?? $this->getDefaultColors(),
            'avatarStyle' => $avatarStyle,
            'faces' => $this->getSvgGroup('visage', 18, 20),
            'features' => $this->getSvgGroup('visage', 21, 24),
            'hairstyles' => $this->getSvgGroup('visage', 25, 31),
        ]);
    }

    /**
     * Retourner le HTML de l'avatar-frame (pour AJAX discret)
     */
    public function preview(Request $request)
    {
        $style = $request->validate([
            'face' => 'required|string|max:50',
            'features' => 'required|string|max:50',
            'hair' => 'required|string|max:50',
        ]);

        $user = auth()->user();
        $colors = $user->avatar_colors ?? $this->getDefaultColors();

        // Sauvegarder silencieusement
        $user->update([
            'avatar_style' => json_encode($style),
        ]);

        return view('components.avatar-frame', [
            'colors' => $colors,
            'style' => $style,
        ])->render();
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
            'avatar_style' => 'nullable|array',
            'avatar_style.face' => 'required_with:avatar_style|string|max:50',
            'avatar_style.features' => 'required_with:avatar_style|string|max:50',
            'avatar_style.hair' => 'required_with:avatar_style|string|max:50',
        ]);

        $data = [
            'avatar_colors' => $validated['avatar_colors'],
        ];

        if (isset($validated['avatar_style'])) {
            $data['avatar_style'] = json_encode($validated['avatar_style']);
        }

        auth()->user()->update($data);

        return redirect()->route('avatar.edit');
    }

    /**
     * Charger un groupe de SVGs.
     */
    private function getSvgGroup(string $folder, int $from, int $to): array
    {
        $items = [];
        foreach (range($from, $to) as $num) {
            $basename = "Perso-{$num}";
            $path = resource_path("svg/{$folder}/{$basename}.svg");
            if (file_exists($path)) {
                $items[$basename] = file_get_contents($path);
            }
        }
        return $items;
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
