<?php

namespace Larams\Cms\Model;

use Larams\Cms\HasRelatedModels;
use Larams\Cms\Model;
use Illuminate\Notifications\Notifiable;
use Larams\Cms\UserTraits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Hash;
use Larams\Cms\UserTraits\EncryptsPassword;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, HasApiTokens, Authenticatable, Authorizable, CanResetPassword, EncryptsPassword, HasRoles, HasRelatedModels;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'logged_at', 'last_ip', 'role_id', 'type', 'require_change'];

    protected $hidden = [
        'password',
        'remember_token'
    ];

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

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password);
        }
    }
}
