<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Roles extends Model
{
    protected $fillable = [
        'name',
        'descriptions',
    ];

    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_code', 'id', 'user_code');
    // }

    public function userRoles()
    {
        return $this->hasMany(User_roles::class, 'role_id');
    }
}
