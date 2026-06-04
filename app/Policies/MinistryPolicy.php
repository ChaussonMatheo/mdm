<?php

namespace App\Policies;

use App\Models\Ministry;
use App\Models\User;

class MinistryPolicy
{
    /**
     * Determine whether the user can modify the ministry (update, delete, assign).
     * Only allows modification if the user belongs to the same family.
     */
    public function modify(User $user, Ministry $ministry): bool
    {
        return $user->family_id === $ministry->family_id;
    }
}
