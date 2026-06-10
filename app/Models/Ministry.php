<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ministry extends Model
{
    protected $fillable = ['family_id', 'name', 'description', 'emoji'];

    /**
     * Get the family that this ministry belongs to.
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get the users assigned to this ministry (all roles).
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Get all assignments (pivot) for this ministry.
     */
    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the main assigned user (titulaire).
     */
    public function titulaire()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('role', 'titulaire')
            ->withTimestamps();
    }

    /**
     * Get substitute users (suppleants).
     */
    public function suppleants()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('role', 'suppleant')
            ->withTimestamps();
    }
}
