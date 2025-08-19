<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = [
        'name',
        'code',
    ];

    public function users(){
        return $this->hasMany(User::class,);
    }
    public function Positions(){
        return $this->hasMany(Positions::class,);
    }
}
