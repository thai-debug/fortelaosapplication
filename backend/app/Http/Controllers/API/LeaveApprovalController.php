<?php

namespace App\Http\Controllers\API;
use App\Http\Resources\LeaveApprovalResource;
use App\Models\Leave_approvals;

use Illuminate\Http\Request;

class LeaveApprovalController
{
    public function index()
    {
        $approvals = Leave_approvals::with('approver', 'leaveRequest.user', 'leaveRequest.leaveType')->get();
        return LeaveApprovalResource::collection($approvals);
    }

    public function show(Leave_approvals $leaveApproval)
    {
        $leaveApproval->load('approver', 'leaveRequest');
        return new LeaveApprovalResource($leaveApproval);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'approver_user_code' => 'required|string|exists:users,user_code',
            'leave_request_id' => 'required|exists:leave_requests,id',
            'action' => 'required|string|in:approved,rejected',
            'comment' => 'nullable|string',
            'submitted_at' => 'required|date',
        ]);

        $approval = Leave_approvals::create($validated);

        // Optionally update leave request status
        $requestModel = $approval->leaveRequest;
        $requestModel->update(['status' => $validated['action']]);

        return response()->json(new LeaveApprovalResource($approval), 201);
    }

    public function destroy(Leave_approvals $leaveApproval)
    {
        $leaveApproval->delete();
        return response()->json(null, 204);
    }

}
