<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
        ];
    }

    // Relationships
    public function leaveRequests()
    {
        return $this->hasMany(Leave_requests::class, 'user_code', 'user_code');
    }

    public function leaveBalances()
    {
        return $this->hasMany(Leave_balances::class, 'user_code', 'user_code');
    }

    public function approvedLeaves()
    {
        return $this->hasMany(Overtime_approvals::class, 'approver_user_code', 'user_code');
    }

    public function UserRoles(){
        return $this->belongsTo(Roles::class,'user_code','user_code');
    }

    // Helper method
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
