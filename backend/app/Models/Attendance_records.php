<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance_records extends Model
{
    protected $table = [
        'user_code',
        'work_date',
        'morning_check_in',
        'morning_check_out',
        'afternoon_check_in',
        'evening_check_out',
        'import_file_name',
        'file_path',
        'submitted_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
