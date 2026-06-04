<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('sessions.{sessionId}', function ($user, $sessionId) {
    $session = \App\Models\Session::find($sessionId);
    
    if (!$session) return false;

    // Check if user is a participant or the creator
    $isParticipant = $session->participants()->where('user_id', $user->id)->exists();
    
    if ($isParticipant || (int)$user->id === (int)$session->user_id) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar_colors' => $user->avatar_colors,
            'avatar_style' => $user->avatar_style,
            'avatar_html' => \App\Support\AvatarRenderer::renderInline($user),
        ];
    }

    return false;
});
