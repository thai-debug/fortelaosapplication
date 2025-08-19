<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave_approvals extends Model
{
    protected $fillable = [
        'approver_user_code',
        'leave_request_id',
        'action',
        'comment',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_user_code', 'user_code');
    }

    public function leaveRequest(): BelongsTo
    {
        return $this->belongsTo(Leave_requests::class);
    }
}
