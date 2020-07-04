<?php

namespace Larams\Cms\Model;

use Larams\Cms\Model;

class Permission extends Model
{

    protected $fillable = ['permission', 'title'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions', 'permission_id', 'role_id');
    }

    public function matches($permission)
    {
        if (preg_match($this->permission, $permission)) {
            return true;
        }
        return false;
    }
}
