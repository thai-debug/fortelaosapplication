<?php

namespace App\Http\Controllers\API;

use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoleResource::collection(Roles::with('userRoles')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
            'description' => 'nullable|string',
        ]);

        $role = Roles::create($validated);
        return response()->json(new RoleResource($role), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $role)
    {
        $role->load('userRoles');
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roles $role)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update($validated);
        return response()->json(new RoleResource($role), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roles $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }
}
