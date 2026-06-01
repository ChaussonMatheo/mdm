<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModuleCategory extends Model
{
    protected $fillable = ['name', 'color'];

    /**
     * Get the modules in this category.
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
