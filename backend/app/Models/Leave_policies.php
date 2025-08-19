<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave_policies extends Model
{
    protected $table = "leave_policies";
    protected $fillable = [
        "leave_type_id",
        "employment_type_id",
        "entitlement_day",
        "accrual_method",
        "carryover_max"
    ];

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(Leave_types::class);
    }

    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(Employment_types::class);
    }
}
