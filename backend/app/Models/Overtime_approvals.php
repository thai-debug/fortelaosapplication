<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Overtime_approvals extends Model
{
   protected $fillable = [
        'approver_user_code', 'overtime_request_id', 'action', 'comment', 'submitted_at'
    ];

   protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_user_code', 'user_code');
    }

    public function overtimeRequest(): BelongsTo
    {
        return $this->belongsTo(Overtime_requests::class);
    }
}
