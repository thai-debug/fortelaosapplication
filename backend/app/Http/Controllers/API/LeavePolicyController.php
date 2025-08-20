<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\LeavePolicyResource;
use App\Models\Leave_policies;

class LeavePolicyController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $policies = Leave_policies::with('leaveType', 'employmentType')->get();
        return LeavePolicyResource::collection($policies);
    }

    public function show(Leave_policies $leavePolicy)
    {
        $leavePolicy->load('leaveType', 'employmentType');
        return new LeavePolicyResource($leavePolicy);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'employment_type_id' => 'required|exists:employment_types,id',
            'entitlement_days' => 'required|string|max:50',
            'accrual_method' => 'nullable|string|max:100',
            'carryover_max' => 'nullable|string|max:50',
        ]);

        $policy = Leave_policies::create($validated);
        return response()->json(new LeavePolicyResource($policy), 201);
    }

    public function update(Request $request, Leave_policies $leavePolicy)
    {
        $validated = $request->validate([
            'leave_type_id' => 'sometimes|required|exists:leave_types,id',
            'employment_type_id' => 'sometimes|required|exists:employment_types,id',
            'entitlement_days' => 'sometimes|required|string|max:50',
            'accrual_method' => 'nullable|string|max:100',
            'carryover_max' => 'nullable|string|max:50',
        ]);

        $leavePolicy->update($validated);
        return response()->json(new LeavePolicyResource($leavePolicy), 200);
    }

    public function destroy(Leave_policies $leavePolicy)
    {
        $leavePolicy->delete();
        return response()->json(null, 204);
    }

}
