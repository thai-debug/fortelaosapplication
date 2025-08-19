<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employment_types extends Model
{
    protected $table = [
        'name',
        'descriptions'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

        public function LeavePolicies(){
        return $this->hasMany(Leave_policies::class);
    }
}
