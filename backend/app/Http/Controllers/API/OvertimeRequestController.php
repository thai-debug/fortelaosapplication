<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\OvertimeRequestResource;
use App\Models\Overtime_requests;

class OvertimeRequestController
{
    public function index()
    {
        $requests = Overtime_requests::with('user', 'approvals.approver')->get();
        return OvertimeRequestResource::collection($requests);
    }

    public function show(Overtime_requests $overtimeRequest)
    {
        $overtimeRequest->load('user', 'approvals.approver');
        return new OvertimeRequestResource($overtimeRequest);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_user_code' => 'required|string|exists:users,user_code',
            'date' => 'required|date',
            'hours' => 'required|date_format:H:i', // Or use decimal: 'numeric|min:0.5'
            'reason' => 'required|string|max:500',
            'status' => 'required|string|in:pending,approved,rejected',
            'submitted_at' => 'required|date',
        ]);

        $ot = Overtime_requests::create($validated);
        return response()->json(new OvertimeRequestResource($ot), 201);
    }

    public function update(Request $request, Overtime_requests $overtimeRequest)
    {
        $validated = $request->validate([
            'hours' => 'sometimes|required|date_format:H:i',
            'reason' => 'sometimes|required|string|max:500',
            'status' => 'sometimes|required|string|in:pending,approved,rejected',
        ]);

        $overtimeRequest->update($validated);
        return response()->json(new OvertimeRequestResource($overtimeRequest), 200);
    }

    public function destroy(Overtime_requests $overtimeRequest)
    {
        $overtimeRequest->delete();
        return response()->json(null, 204);
    }

}
