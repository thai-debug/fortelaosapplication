<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User_roles extends Model
{
  protected $table = "user_roles";
    protected $fillable = [
      'user_code',
      'role_id'  
    ];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_code', 'user_code');
    // }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
