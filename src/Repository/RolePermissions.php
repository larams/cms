<?php

namespace Larams\Cms\Repository;

use Larams\Cms\Model\RolePermission;
use Larams\Cms\Repository;

class RolePermissions extends Repository
{
    /** @var RolePermission */
    protected $model;

    public function __construct(RolePermission $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function buildQuery($params)
    {
        $query = parent::buildQuery($params);

        if (!empty($params['role_id'])) {
            $query = $query->where('role_id', $params['role_id']);
        }

        return $query;
    }

}
