<?php

namespace Larams\Cms\Model;

use Larams\Cms\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['title'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'role_id', 'permission_id');
    }

    public function getPermissionIdsAttribute()
    {
        return $this->permissions()->pluck('permission_id')->toArray();
    }

    public function isAllowed($permission)
    {

        if (in_array($permission, config('larams.common_permissions'))) {
            return true;
        }

        $perms = $this->permissions()->get();
        foreach ($perms as $perm) {
            //'/admin\.structure\.(.*?)/'
            $perm->permission = str_replace('.', '\.', $perm->permission);
            $perm->permission = '/^' . str_replace('*', '(.*?)', $perm->permission) . '$/';
            if ($perm->matches($permission) === true) {
                return true;
            };
        }
        return false;
    }
}
