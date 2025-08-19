<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave_balances extends Model
{
    protected $fillable = [
        'user_code',
        'leave_type_id',
        'year',
        'opening_balance',
        'accrued',
        'used',
        'adjusted',
        'remaining'
    ];

    protected $casts = ['year' => 'integer'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(Leave_types::class);
    }
}
