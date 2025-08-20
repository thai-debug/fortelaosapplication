<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\LeaveBalanceResource;
use App\Models\Leave_balances;

class LeaveBalanceController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $balances = Leave_balances::with('user', 'leaveType')->get();
        return LeaveBalanceResource::collection($balances);
    }
public function show(Leave_balances $leaveBalance)
    {
        $leaveBalance->load('user', 'leaveType');
        return new LeaveBalanceResource($leaveBalance);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_code' => 'required|string|exists:users,user_code',
            'leave_type_id' => 'required|exists:leave_types,id',
            'year' => 'required|integer|between:1900,2100',
            'opening_balance' => 'required|integer|min:0',
            'accrued' => 'required|integer|min:0',
            'used' => 'required|integer|min:0',
            'adjusted' => 'required|integer|min:0',
        ]);

        $validated['remaining'] = $validated['opening_balance'] + $validated['accrued'] + $validated['adjusted'] - $validated['used'];

        $balance = Leave_balances::create($validated);
        return response()->json(new LeaveBalanceResource($balance), 201);
    }

    public function update(Request $request, Leave_balances $leaveBalance)
    {
        $validated = $request->validate([
            'opening_balance' => 'sometimes|required|integer|min:0',
            'accrued' => 'sometimes|required|integer|min:0',
            'used' => 'sometimes|required|integer|min:0',
            'adjusted' => 'sometimes|required|integer|min:0',
        ]);

        $validated['remaining'] = ($validated['opening_balance'] ?? $leaveBalance->opening_balance)
                                + ($validated['accrued'] ?? $leaveBalance->accrued)
                                + ($validated['adjusted'] ?? $leaveBalance->adjusted)
                                - ($validated['used'] ?? $leaveBalance->used);

        $leaveBalance->update($validated);
        return response()->json(new LeaveBalanceResource($leaveBalance), 200);
    }

    public function destroy(Leave_balances $leaveBalance)
    {
        $leaveBalance->delete();
        return response()->json(null, 204);
    }

}
