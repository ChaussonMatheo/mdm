<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    protected $table = 'game_sessions';

    protected $fillable = ['user_id', 'theme', 'code', 'status'];

    /**
     * Get the user that created the session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the modules for the session.
     */
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'game_session_modules', 'game_session_id', 'module_id');
    }

    /**
     * Get the participants for the session.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'game_session_participants', 'game_session_id', 'user_id')->withTimestamps();
    }

    /**
     * Generate a unique session code.
     */
    public static function generateCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 3)).'-'.str_pad(random_int(100, 999), 3, '0', STR_PAD_LEFT);
        } while (static::where('code', $code)->exists());

        return $code;
    }
}
