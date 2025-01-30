<?php

namespace LaravelLogin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RolePermission extends Model
{
    protected $table = 'sso_roles_permissions';
    protected $fillable = [
        'name',
        'permission',
        "guuid",
        'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(SSOUser::class, 'user_id');
    }
}