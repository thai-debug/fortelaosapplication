<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employment_types extends Model
{
    protected $table = "employment_types";
    protected $fillable = [
        'name',
        'descriptions'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_type_id');
    }

    public function leavePolicies(): HasMany
    {
        return $this->hasMany(Leave_policies::class, 'employment_type_id');
    }
}
