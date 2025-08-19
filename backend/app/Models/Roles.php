<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'name',
        'descriptions',
    ];

    public function Userroles(){
        return $this->hasMany(user_roles::class);
    }
}
