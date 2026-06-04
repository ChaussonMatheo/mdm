<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'phone', 'password', 'family_id', 'avatar_colors', 'avatar_style'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the family this user belongs to.
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get the sessions created by this user.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the sessions this user has joined.
     */
    public function joinedSessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'game_session_participants', 'user_id', 'game_session_id')->withTimestamps();
    }

    /**
     * Get the ministries assigned to this user.
     */
    public function ministries(): BelongsToMany
    {
        return $this->belongsToMany(Ministry::class)->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'avatar_colors' => 'array',
            'avatar_style' => 'array',
        ];
    }

    /**
     * Get the rendered avatar HTML for this user.
     */
    public function getAvatarHtmlAttribute(): string
    {
        return \App\Support\AvatarRenderer::renderInline($this);
    }
}
