<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime_approvals extends Model
{
    protected $table = [
        'user_code',
        'overtime_request_id',
        'action',
        'comment',
        'submitted_at',
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function OvertimeRequest(){
        return $this->hasOne(Overtime_requests::class);
    }
}
