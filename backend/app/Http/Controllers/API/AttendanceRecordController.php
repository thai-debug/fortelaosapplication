<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\AttendanceRecordResource;
use App\Models\Attendance_records;
use App\Models\User;

class AttendanceRecordController
{
    /**
     * Display a listing of the resource.
     */
    //public function index()
    //{
    //return AttendanceRecordResource::collection(Attendance_records::with('user')->get());
    //}

    /**
     * Get all attendance records for a specific user.
     * @param string user_code
     * ?user_code=EMP001
     * 
     */
    public function index()
    {
        $query = Attendance_records::query();

        if (request()->has('user_code')) {
            $query->where('user_code', request('user_code'));
        }

        $records = $query->with('user')->get();

        return AttendanceRecordResource::collection($records);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_code' => 'required|string|exists:users,user_code',
            'work_date' => 'required|date|unique:attendance_records,work_date,NULL,id,user_code,' . $request->user_code,
            'morning_check_in' => 'nullable|',
            'morning_check_out' => 'nullable|after:morning_check_in',
            'afternoon_check_in' => 'nullable|',
            'evening_check_out' => 'nullable|after:afternoon_check_in',
            'import_file_name' => 'nullable|string|max:255',
            'file_path' => 'nullable|string',
            'submitted_at' => 'required|date',
        ]);

        $record = Attendance_records::create($validated);
        return response()->json(new AttendanceRecordResource($record), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance_records $attendanceRecord)
    {
        $attendanceRecord->load('user');
        return new AttendanceRecordResource($attendanceRecord);
    }

    /**
     * Get all attendance records for a specific user.
     */
    public function getByUser($userCode)
    {
        // Validate the user_code exists
        $user = User::where('user_code', $userCode)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Get all attendance records for this user
        $records = Attendance_records::where('user_code', $userCode)
            ->with('user') // Load user info
            ->orderBy('work_date', 'desc')
            ->get();

        return AttendanceRecordResource::collection($records);
    }

    /**
     * Get a specific attendance record for a user on a specific date.
     */
    public function showByUserAndDate($userCode, $workDate)
    {
        $record = Attendance_records::where('user_code', $userCode)
            ->where('work_date', $workDate)
            ->with('user')
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Attendance record not found.'], 404);
        }

        return new AttendanceRecordResource($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance_records $attendanceRecord)
    {
        $validated = $request->validate([
            'morning_check_in' => 'nullable',
            'morning_check_out' => 'nullable|after:morning_check_in',
            'afternoon_check_in' => 'nullable',
            'evening_check_out' => 'nullable|after:afternoon_check_in',
            'import_file_name' => 'nullable|string|max:255',
            'file_path' => 'nullable|string',
            'submitted_at' => 'sometimes|required|date',
        ]);

        $attendanceRecord->update($validated);
        return response()->json(new AttendanceRecordResource($attendanceRecord), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance_records $attendanceRecord)
    {
        $attendanceRecord->delete();
        return response()->json(null, 204);
    }
}
