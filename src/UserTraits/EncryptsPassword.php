<?php

namespace Larams\Cms\UserTraits;

trait EncryptsPassword
{

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = \Hash::make($password);
        }
    }

}
