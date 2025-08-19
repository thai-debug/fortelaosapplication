<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = [
        'title',
        'level',
        'department_id',
    ];

    public function user(){
        return $this->hasMany(user::class);
    }

    public function Departments(){
        return $this->belongsTo(Department::class);
    }
}
