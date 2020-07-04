<?php

namespace Larams\Cms\UserTraits;

use Larams\Cms\Model\Role;

trait HasRoles {

    protected $hiddenFields = [];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAllowed($permission)
    {
        if (empty($this->role)) {
            return true;
        }

        return $this->role->isAllowed($permission);
    }

}
