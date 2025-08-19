<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceRecordResource;
use App\Models\Attendance_records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Attendance_records::where('user_code', Auth::user()->user_code)
                    ->orderBy('work_date', 'desc')
                    ->paginate(20);
                    
        return AttendanceRecordResource::collection($records);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
            'work_date' => 'required|date',
            'morning_check_in' => 'nullable|date_format:H:i',
            'morning_check_out' => 'nullable|date_format:H:i|after:morning_check_in',
            'afternoon_check_in' => 'nullable|date_format:H:i',
            'evening_check_out' => 'nullable|date_format:H:i|after:afternoon_check_in',
        ]);

        $validated['user_code'] = Auth::user()->user_code;
        
        $record = Attendance_records::create($validated);
        
        return new AttendanceRecordResource($record);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance_records $record)
    {
            $this->authorize('view', $record);
        return new AttendanceRecordResource($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance_records $record)
    {
                $this->authorize('update', $record);
        
        $validated = $request->validate([
            'morning_check_in' => 'nullable|date_format:H:i',
            'morning_check_out' => 'nullable|date_format:H:i|after:morning_check_in',
            'afternoon_check_in' => 'nullable|date_format:H:i',
            'evening_check_out' => 'nullable|date_format:H:i|after:afternoon_check_in',
        ]);
        
        $record->update($validated);
        
        return new AttendanceRecordResource($record);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance_records $record)
    {
        $this->authorize('delete', $record);
        $record->delete();
        return response()->noContent();
    }
}
