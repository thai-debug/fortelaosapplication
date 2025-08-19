<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime_requests extends Model
{
    protected $fillable = [
        'user_code',
        'date',
        'hours',
        'reaspm',
        'status',
        'submitted_at',
    ];

    public function user(){
        return $this->hasMany(User::class);
    }
    public function OvertimeApprovals(){
        return $this->hasOne(Overtime_approvals::class);
    }
}
