<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\LeaveTypeResource;
use App\Models\Leave_types;

class LeaveTypeController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LeaveTypeResource::collection(Leave_types::with('leavePolicies', 'leaveRequests')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:leave_types,code|max:50',
            'description' => 'nullable|string',
        ]);

        $type = Leave_types::create($validated);
        return response()->json(new LeaveTypeResource($type), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave_types $leaveType)
    {
        $leaveType->load('leavePolicies', 'leaveRequests');
        return new LeaveTypeResource($leaveType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave_types $leaveType)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50|unique:leave_types,code,' . $leaveType->id,
            'description' => 'nullable|string',
        ]);

        $leaveType->update($validated);
        return response()->json(new LeaveTypeResource($leaveType), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(Leave_types $leaveType)
    {
        $leaveType->delete();
        return response()->json(null, 204);
    }
}
