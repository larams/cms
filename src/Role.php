<?php

namespace Larams\Cms;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = ['title'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'role_id', 'permission_id');
    }

    public function isAllowed($permission)
    {
        $perms = $this->permissions()->get();
        foreach ($perms as $perm) {
            //'/admin\.structure\.(.*?)/'
            $perm->permission = str_replace('.', '\.', $perm->permission);
            $perm->permission = '/' . str_replace('*', '(.*?)', $perm->permission) . '/';
            if ($perm->matches($permission) === true) {
                return true;
            };
        }
        return false;
    }
}
