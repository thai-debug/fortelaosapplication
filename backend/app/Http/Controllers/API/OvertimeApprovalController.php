<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\OvertimeApprovalResource;
use App\Models\Overtime_approvals;

class OvertimeApprovalController
{
    public function index()
    {
        $approvals = Overtime_approvals::with('approver', 'overtimeRequest.user')->get();
        return OvertimeApprovalResource::collection($approvals);
    }

    public function show(Overtime_approvals $overtimeApproval)
    {
        $overtimeApproval->load('approver', 'overtimeRequest');
        return new OvertimeApprovalResource($overtimeApproval);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'approver_user_code' => 'required|string|exists:users,user_code',
            'overtime_request_id' => 'required|exists:overtime_requests,id',
            'action' => 'required|string|in:approved,rejected',
            'comment' => 'nullable|string',
            'submitted_at' => 'required|date',
        ]);

        $approval = Overtime_approvals::create($validated);

        // Update parent request status
        $otRequest = $approval->overtimeRequest;
        $otRequest->update(['status' => $validated['action']]);

        return response()->json(new OvertimeApprovalResource($approval), 201);
    }

    public function destroy(Overtime_approvals $overtimeApproval)
    {
        $overtimeApproval->delete();
        return response()->json(null, 204);
    }

}
