<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        //$departments = Department::with('positions', 'users')->get(); 
        return DepartmentResource::collection($departments);

    }

    /**
     * Store a newly created resource in storage.
     */
       public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:departments,code|max:50',
        ]);

        $department = Department::create($validated);
        return response()->json(new DepartmentResource($department), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load('positions', 'users');
        return new DepartmentResource($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50|unique:departments,code,' . $department->id,
        ]);

        $department->update($validated);
        return response()->json(new DepartmentResource($department), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(null, 204);
    }
}
