<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_roles extends Model
{
    protected $fillable = [
      'user_code',
      'role_id'  
    ];

    public function Roles(){
        return $this->belongsTo(Roles::class);
    }
    public function users(){
      return $this->hasOne(User::class);
    }
}
