<?php

namespace Larams\Cms\Repository;

use Larams\Cms\Repository;
use Larams\Cms\Model\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class Users extends Repository implements UserRepositoryInterface
{
    /** @var User $model */
    protected $model;

    protected $sortMap = [
    ];

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function buildQuery($params)
    {
        $select = parent::buildQuery($params);

        $select = $select
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id');

        $columns = [
            'users.*',
            'roles.title as role_title',
        ];

        if (!empty($params['role_id'])) {
            $select = $select->where('role_id', $params['role_id']);
        }

        if (empty($params['count'])) {
            $select = $select
                ->groupBy('users.id')
                ->select($columns);
        }

        return $select;
    }

    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        /** @var User $user */
        $user = $this->model->find($username);

        if (empty($user)) {
            return;
        }

        return new \Laravel\Passport\Bridge\User($user->getAuthIdentifier());

    }
}
