<?php

namespace App\Repository;

use App\Model\Role;
use App\Model\RolePermission;
use App\Repository;

class Roles extends Repository
{
    /** @var Role $model */
    protected $model;

    /** @var RolePermissions */
    protected $rolePermissions;

    public function __construct(Role $model, RolePermissions $rolePermissions)
    {
        $this->model = $model;
        $this->rolePermissions = $rolePermissions;
    }

    public function buildQuery($params)
    {
        $query = parent::buildQuery($params);

        if (empty($params['count'])) {
            $query = $query->groupBy('roles.id');
        }

        $query = $query
            ->select([
                'roles.*'
            ])
            ->orderBy('roles.title', 'ASC');

        return $query;
    }

    public function create($input)
    {
        $role = parent::create($input);

        if (!empty($input['permissionIds'])) {
            $this->createRolePermissions($role, $input['permissionIds']);
        }
    }

    public function update($model, $input)
    {
        $model = parent::update($model, $input);

        if (!empty($input['permissionIds'])) {
            $rows = $this->rolePermissions->filter(['role_id' => $model->id]);
            /** @var RolePermission $row */
            foreach ($rows as $row) {
                $row->delete();
            }
        }

        if (!empty($input['permissionIds'])) {
            $this->createRolePermissions($model, $input['permissionIds']);
        }
    }

    public function createRolePermissions($role, $permissionIds)
    {
        foreach ($permissionIds as $permissionId) {
            $this->rolePermissions->create([
                'role_id' => $role->id,
                'permission_id' => $permissionId,
            ]);
        }
    }
}
