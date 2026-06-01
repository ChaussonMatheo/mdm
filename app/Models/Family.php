<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $fillable = ['name', 'unique_code'];

    /**
     * Get the users that belong to this family.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Family $family) {
            if (empty($family->unique_code)) {
                $family->unique_code = static::generateUniqueCode();
            }
        });
    }

    /**
     * Generate a unique code in MCDF format (e.g., M1234).
     */
    public static function generateUniqueCode(): string
    {
        do {
            $code = 'M'.str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        } while (static::where('unique_code', $code)->exists());

        return $code;
    }
}
