<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::with([
                'department',
                'position',
                'employmentType',
                'roles'
            ])->get();
            return UserResource::collection($users);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_code' => 'required|string|unique:users,user_code|max:50',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'hire_date' => 'required|date',
                'dob' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
                'emergency_contact' => 'nullable|string|max:100',
                'address' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
                'department_id' => 'required|exists:departments,id',
                'position_id' => 'required|exists:positions,id',
                'employment_type_id' => 'required|exists:employment_types,id',
                'status' => 'sometimes|boolean',
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);

            return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully!',
            'data' => new UserResource($user)
        ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $user->load('department', 'position', 'employmentType', 'roles');
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'user_code' => 'sometimes|required|string|max:50|unique:users,user_code,' . $user->user_code . ',user_code',
                'first_name' => 'sometimes|required|string|max:100',
                'last_name' => 'sometimes|required|string|max:100',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->user_code . ',user_code',
                'phone' => 'nullable|string|max:20',
                'hire_date' => 'sometimes|required|date',
                'dob' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
                'emergency_contact' => 'nullable|string|max:100',
                'address' => 'required|string',
                'password' => 'nullable|string|min:8|confirmed',
                'department_id' => 'nullable|exists:departments,id',
                'position_id' => 'nullable|exists:positions,id',
                'employment_type_id' => 'nullable|exists:employment_types,id',
                'status' => 'sometimes|boolean',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                // remove password from validated data if not provided
                unset($validated['password']);
            }

            $user->update($validated);

            // Reload relationships
            $user->load('department', 'position', 'employmentType');

            return response()->json([
                'status' => 'success',
                'message' => 'Employee updated successfully!',
                'data' => new UserResource($user)
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function last()
    {
        try {
            $last = User::latest()->first();
            return response()->json($last, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getNextEmployeeCode($department_id)
    {
        try {
            $lastemEmployee = User::latest('id')->first();

            $nextId = ($lastemEmployee->id ?? 0) + 1;

            //fetch department code
            $department = Department::find($department_id);

            if (!$department) {
                return response()->json([
                    'message' => 'Department not found',
                ], 404);
            }

            // Format department code or fallback
            $departmentCode = $department->code ?? strtoupper(substr($department->name, 0, 3));

            // Company prefix
            $companyPrefix = 'FL-';

            // Format employee code
            $employeeCode = sprintf('%s%s%03d', $companyPrefix, $departmentCode, $nextId);

            return response()->json([
                'next_code' => $employeeCode,
                'next_id' => $nextId
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to generate employee code',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
