<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave_types extends Model
{
    protected $table = [
        "name",
        "code",
    ];

    public function LeaveRequests()
    {
        return $this->hasMany(Leave_requests::class);
    }

    public function LeavePolicies()
    {
        return $this->hasMany(Leave_policies::class);
    }
}
