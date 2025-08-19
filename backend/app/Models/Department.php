<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Positions::class, 'department_id');
    }
}
