<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Role;

class RoleService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getRoleID(UserRole $role): int
    {
        return Role::query()
            ->where('name', $role->value)
            ->value('id');
    }
}
