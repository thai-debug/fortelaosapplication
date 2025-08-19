<?php

namespace App\Policies;

use App\Models\Attendance_records;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class AttendanceRecordPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function view(User $user, Attendance_records $record): bool
    {
        return $user->user_code === $record->user_code ||
            $user->hasRole('manager') ||
            $user->hasRole('hr');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendance_records $record): bool
    {
        // Only allow updates if record is from today or future
        return $user->user_code === $record->user_code &&
            $record->work_date >= now()->format('Y-m-d');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendance_records $record): bool
    {
        return $user->hasRole('hr') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attendance_records $attendanceRecords): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendance_records $attendanceRecords): bool
    {
        return false;
    }
}
