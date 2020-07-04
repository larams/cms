<?php

namespace Larams\Cms\Repository;

use Larams\Cms\Model\Permission;
use Larams\Cms\Repository;

class Permissions extends Repository
{
    /** @var Permission */
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function forRole($roleId)
    {
        return $this->getModel()
            ->leftJoin('roles_permissions', 'roles_permissions.permission_id', '=', 'permissions.id')
            ->where('roles_permissions.role_id', $roleId)
            ->select(['permissions.permission'])
            ->orderBy('permissions.permission')
            ->pluck('permission');
    }

}
