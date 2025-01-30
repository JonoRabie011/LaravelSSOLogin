<?php

namespace LaravelLogin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SSOUser extends Authenticatable
{
    protected $table = 'sso_users';

    protected $fillable = [
        'guuid',
        'firstName',
        'lastName',
        'token',
        'refreshToken',
        'email',
        'externalId'
    ];

    public function role()
    {
        return $this->belongsTo(RolePermission::class, 'sso_user_roles', 'user_id', 'role_id');
    }
//
//    public function hasPermission($permission): bool
//    {
//        return $this->roles()->where('permission', $permission)->exists();
//    }
}
