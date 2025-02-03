<?php

namespace LaravelLogin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SSOUser extends Authenticatable
{
    protected $table;

    protected $fillable = [
        'guuid',
        'firstName',
        'lastName',
        'token',
        'refreshToken',
        'email',
        'externalId'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('laravel-sso-login.user_table', 'sso_users'); // Default to 'sso_users' if not set
    }

    public function roles(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'user_id');
    }

//    public function hasPermission($permission): bool
//    {
//        return $this->roles()->where('permission', $permission)->exists();
//    }
}
