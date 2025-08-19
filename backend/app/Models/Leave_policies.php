<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave_policies extends Model
{
protected $fillable = [
    "leave_type_id",
    "employment_type_id",
    "entitlement_day",
    "accrual_method",
    "accaryover_max"
];

    public function leaveTypes()
    {
        return $this->belongsTo(Leave_types::class);
    }
        public function EmploymentTypes()
    {
        return $this->belongsTo(Employment_types::class);
    }
}
