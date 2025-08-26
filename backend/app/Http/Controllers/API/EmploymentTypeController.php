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
        //return EmploymentTypeResource::collection(Employment_types::with('users', 'leavePolicies')->get());
        $employmentType = Employment_types::all();
        return EmploymentTypeResource::collection($employmentType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
        ]);

        $type = Employment_types::create($validated);
        return response()->json(new EmploymentTypeResource($type), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employment_types $employmentType)
    {
        $employmentType->load('users', 'leavePolicies');
        return new EmploymentTypeResource($employmentType);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employment_types $employmentType)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'descriptions' => 'nullable|string',
        ]);

        $employmentType->update($validated);
        return response()->json(new EmploymentTypeResource($employmentType), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employment_types $employmentType)
    {
        $employmentType->delete();
        return response()->json(null, 204);
    }
}
