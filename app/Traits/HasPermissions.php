<?php

namespace App\Traits;

use Spatie\Permission\Traits\HasRoles;

trait HasPermissions
{
    use HasRoles;

    public function hasPermissionTo($permission): bool
    {
        return $this->hasPermissionViaRoles($permission) || parent::hasPermissionTo($permission);
    }

    public function hasAnyPermission(...$permissions): bool
    {
        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermissionTo($permission)) {
                return true;
            }
        }

        return false;
    }

    public function hasAllPermissions(...$permissions): bool
    {
        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermissionTo($permission)) {
                return false;
            }
        }

        return true;
    }
} 