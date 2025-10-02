<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    //protected $primaryKey = 'holidays_date';
    //public $incrementing = false;
    //protected $keyType = 'date';
    protected $fillable = [
        'holidays_from_date',
        'holidays_to_date',
        'name',
        'is_public',
    ];
    protected $casts = [
        'holidays_from_date' => 'date',
        'holidays_to_date' => 'date',
        'is_public' => 'boolean',
    ];
        // Optional: Scope to check if a date is a holiday
    public function scopeOnDate($query, $date)
    {
        return $query->where('holidays_from_date', $date)->orWhere('holidays_to_date', $date);
    }
}
