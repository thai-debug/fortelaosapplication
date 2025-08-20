<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\LeaveRequestResource;
use App\Models\Leave_requests;

class LeaveRequestController
{
    public function index()
    {
        $requests = Leave_requests::with('user', 'leaveType', 'approvals.approver')->get();
        return LeaveRequestResource::collection($requests);
    }

    public function show(Leave_requests $leaveRequest)
    {
        $leaveRequest->load('user', 'leaveType', 'approvals.approver');
        return new LeaveRequestResource($leaveRequest);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_code' => 'required|string|exists:users,user_code',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'status' => 'required|string|in:pending,approved,rejected,cancelled',
            'submitted_at' => 'required|date',
        ]);

        $validated['days'] = (new \DateTime($validated['start_date']))->diff(new \DateTime($validated['end_date']))->days + 1;

        $requestModel = Leave_requests::create($validated);
        return response()->json(new LeaveRequestResource($requestModel), 201);
    }

    public function update(Request $request, Leave_requests $leaveRequest)
    {
        $validated = $request->validate([
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'reason' => 'sometimes|required|string',
            'status' => 'sometimes|required|string|in:pending,approved,rejected,cancelled',
        ]);

        if (isset($validated['start_date']) || isset($validated['end_date'])) {
            $start = $validated['start_date'] ?? $leaveRequest->start_date;
            $end = $validated['end_date'] ?? $leaveRequest->end_date;
            $validated['days'] = (new \DateTime($start))->diff(new \DateTime($end))->days + 1;
        }

        $leaveRequest->update($validated);
        return response()->json(new LeaveRequestResource($leaveRequest), 200);
    }

    public function destroy(Leave_requests $leaveRequest)
    {
        $leaveRequest->delete();
        return response()->json(null, 204);
    }

}
