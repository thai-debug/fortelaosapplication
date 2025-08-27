<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance_records extends Model
{
    protected $fillable = [
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

    protected $casts = [
        //'work_date' => 'date',
        ///'morning_check_in' => 'H:i:s',
        //'morning_check_out' => 'H:i:s',
        //'afternoon_check_in' => 'H:i:s',
        //'evening_check_out' => 'H:i:s',
        //'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'user_code');
    }

        // Helper method to calculate total worked hours
    // public function calculateTotalHours()
    // {
    //     $totalMinutes = 0;
        
    //     if ($this->morning_check_in && $this->morning_check_out) {
    //         $totalMinutes += $this->morning_check_out->diffInMinutes($this->morning_check_in);
    //     }
        
    //     if ($this->afternoon_check_in && $this->evening_check_out) {
    //         $totalMinutes += $this->evening_check_out->diffInMinutes($this->afternoon_check_in);
    //     }
        
    //     return floor($totalMinutes / 60) . 'h ' . ($totalMinutes % 60) . 'm';
    // }
}
