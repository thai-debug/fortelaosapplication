<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave_approvals extends Model
{
    protected $fillable = [
        'approver_user_code',
        'leave_request_id',
        'action',
        'comment'
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_user_code', 'user_code');
    }

    public function leaveRequest()
    {
        return $this->belongsTo(Leave_requests::class);
    }
}
