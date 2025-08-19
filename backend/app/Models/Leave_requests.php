<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave_requests extends Model
{
    protected $fillable = [
        'user_code',
        'leave_type_id',
        'start_date',
        'end_date',
        'days',
        'reason',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }

    public function leaveType()
    {
        return $this->belongsTo(Leave_types::class);
    }

    public function approvals()
    {
        return $this->hasMany(Leave_approvals::class);
    }
}
