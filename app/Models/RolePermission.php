<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 */
class RolePermission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
