<?php

namespace Larams\Cms\Model;

use Larams\Cms\Model;

class UserLogin extends Model
{

    protected $table = 'users_logins';

    protected $fillable = ['ip', 'username', 'has_logged'];
}
