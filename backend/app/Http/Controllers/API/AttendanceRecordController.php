<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\AttendanceRecordResource;
use App\Models\Attendance_records;

class AttendanceRecordController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AttendanceRecordResource::collection(Attendance_records::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_code' => 'required|string|exists:users,user_code',
            'work_date' => 'required|date|unique:attendance_records,work_date,NULL,id,user_code,' . $request->user_code,
            'morning_check_in' => 'nullable|date_format:H:i',
            'morning_check_out' => 'nullable|date_format:H:i|after:morning_check_in',
            'afternoon_check_in' => 'nullable|date_format:H:i',
            'evening_check_out' => 'nullable|date_format:H:i|after:afternoon_check_in',
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance_records $attendanceRecord)
    {
        $validated = $request->validate([
            'morning_check_in' => 'nullable|date_format:H:i',
            'morning_check_out' => 'nullable|date_format:H:i|after:morning_check_in',
            'afternoon_check_in' => 'nullable|date_format:H:i',
            'evening_check_out' => 'nullable|date_format:H:i|after:afternoon_check_in',
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
