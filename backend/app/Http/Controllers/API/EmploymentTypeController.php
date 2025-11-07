<?php

namespace App\Http\Controllers\API;

use App\Models\Employment_types;
use Illuminate\Http\Request;
use App\Http\Resources\EmploymentTypeResource;

class EmploymentTypeController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //return EmploymentTypeResource::collection(Employment_types::with('users', 'leavePolicies')->get());
            $employmentType = Employment_types::all();
            return EmploymentTypeResource::collection($employmentType);
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
                'name' => 'required|string|max:255',
                'descriptions' => 'nullable|string',
            ]);

            $type = Employment_types::create($validated);
            return response()->json(new EmploymentTypeResource($type), 201);
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
    public function show(Employment_types $employmentType)
    {
        try {
            $employmentType->load('users', 'leavePolicies');
            return new EmploymentTypeResource($employmentType);
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
    public function update(Request $request, Employment_types $employmentType)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'descriptions' => 'nullable|string',
            ]);

            $employmentType->update($validated);
            return response()->json(new EmploymentTypeResource($employmentType), 200);
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
    public function destroy(Employment_types $employmentType)
    {
        try {
            $employmentType->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
