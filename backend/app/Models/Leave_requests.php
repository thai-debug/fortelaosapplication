<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leave_requests extends Model
{
    protected $fillable = [
        'user_code',
        'leave_type_id',
        'start_date',
        'end_date',
        'days',
        'reason',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(Leave_types::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Leave_approvals::class, 'leave_request_id');
    }
}
