<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    /**
     * Create a new class instance.
     */

    public function permissionadd()
    {
        $permissions = Permission::all();
    }
}
