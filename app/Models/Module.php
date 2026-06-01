<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    protected $fillable = ['name', 'color', 'module_category_id'];

    /**
     * Get the category this module belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ModuleCategory::class, 'module_category_id');
    }

    /**
     * Get the sessions that use this module.
     */
    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'session_modules');
    }
}
