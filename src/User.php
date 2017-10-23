<?php

namespace Larams\Cms;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends \Eloquent implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'logged_at', 'last_ip', 'type', 'require_change'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function types()
    {
        return [
            'DEV' => trans('admin.role.developer'),
            'ADMIN' => trans('admin.role.administrator'),
            'CUSTOMER' => trans('admin.role.customer'),
        ];
    }

    public function isAdministrator()
    {
        return $this->type == 'ADMIN';
    }

    public function isCustomer()
    {
        return $this->type == 'CUSTOMER';
    }

    public function isDeveloper()
    {
        return $this->type == 'DEV';
    }

    public function getTypeTitleAttribute()
    {
        $types = $this->types();

        return $types[$this->attributes['type']];
    }

    public function setPasswordAttribute($password)
    {

        if (!empty($password)) {
            $this->attributes['password'] = \Hash::make($password);
        }

    }
}
