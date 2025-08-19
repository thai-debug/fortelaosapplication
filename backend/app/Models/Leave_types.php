<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leave_types extends Model
{
    protected $table = [
        "name",
        "code",
        "description",
    ];

    public function leavePolicies(): HasMany
    {
        return $this->hasMany(Leave_policies::class, 'leave_type_id');
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(Leave_requests::class, 'leave_type_id');
    }

    public function leaveBalances(): HasMany
    {
        return $this->hasMany(Leave_balances::class, 'leave_type_id');
    }
}
