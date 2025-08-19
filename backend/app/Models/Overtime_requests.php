<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Overtime_requests extends Model
{
    protected $fillable = [
        'request_user_code',
        'date',
        'hours',
        'reason',
        'status',
        'submitted_at'
    ];

        protected $casts = [
        'date' => 'date',
        'hours' => 'time', // Consider casting to decimal if needed
        'submitted_at' => 'datetime',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_code', 'user_code');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Overtime_approvals::class, 'overtime_request_id');
    }
}
