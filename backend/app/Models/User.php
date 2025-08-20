<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    use SoftDeletes;

    protected $fillable = [
        'user_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'hire_date',
        'status',
        'dob',
        'gender',
        'emergency_contact',
        'password',
        'department_id',
        'position_id',
        'employment_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date:d-m-Y',
        ];
    }

    // Relationships
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Positions::class);
    }

    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(Employment_types::class, 'user_type_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'user_roles', 'user_code', 'role_id', 'user_code', 'id');
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(Attendance_records::class, 'user_code', 'user_code');
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(Leave_requests::class, 'user_code', 'user_code');
    }

    public function leaveBalances(): HasMany
    {
        return $this->hasMany(Leave_balances::class, 'user_code', 'user_code');
    }

    public function overtimeRequests(): HasMany
    {
        return $this->hasMany(Overtime_requests::class, 'request_user_code', 'user_code');
    }

    public function approvedLeaveRequests()
    {
        return $this->hasMany(Leave_approvals::class, 'approver_user_code', 'user_code');
    }

    public function approvedOvertimeRequests()
    {
        return $this->hasMany(Overtime_approvals::class, 'approver_user_code', 'user_code');
    }
}
