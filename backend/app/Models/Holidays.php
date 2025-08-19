<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    protected $table = [
        'holiday_date',
        'name',
        'is_public',
    ];
}
