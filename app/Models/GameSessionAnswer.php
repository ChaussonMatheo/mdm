<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameSessionAnswer extends Model
{
    protected $fillable = ['game_session_id', 'module_id', 'user_id', 'choice'];

    /**
     * Get the session this answer belongs to.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'game_session_id');
    }

    /**
     * Get the module this answer is for.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the user who gave this answer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
