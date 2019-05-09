<?php

namespace Larams\Cms\UserTraits;

use Larams\Cms\Role;

trait HasRoles {

    protected $hiddenFields = [];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAllowed($permission)
    {
        return $this->role->isAllowed($permission);
    }

}
