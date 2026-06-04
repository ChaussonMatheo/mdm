<?php

namespace App\Support;

use App\Models\User;

class AvatarRenderer
{
    /**
     * Rendre le HTML du composant avatar-frame pour un utilisateur.
     */
    public static function render(User $user): string
    {
        $colors = $user->avatar_colors ?? [
            'skin' => '#f5a57f',
            'hair' => '#2d2d2d',
            'secondary' => '#faea2f',
            'accent' => '#f2969f',
        ];

        $style = $user->avatar_style ?? [
            'face' => 'Perso-18',
            'features' => 'Perso-23',
            'hair' => 'Perso-28',
        ];

        return view('components.avatar-frame', [
            'colors' => $colors,
            'style' => $style,
            'size' => 'w-full h-full',
        ])->render();
    }

    /**
     * Rendre le HTML de l'avatar encodé pour JSON (sauts de ligne supprimés).
     */
    public static function renderInline(User $user): string
    {
        $html = static::render($user);
        // Nettoyer pour le mettre dans une chaîne JSON sans casse
        return trim(preg_replace('/\s+/', ' ', $html));
    }
}
