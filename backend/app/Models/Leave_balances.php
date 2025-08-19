<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }

    public function leaveType()
    {
        return $this->belongsTo(Leave_types::class);
    }
}
