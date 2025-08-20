<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserRoleResource;
use Illuminate\Http\Request;
use App\Models\User_roles;

class UserRoleController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserRoleResource::collection(User_roles::with("user", 'role')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_code' => 'required|string|exists:users,user_code',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole = User_roles::create($validated);
        return response()->json(new UserRoleResource($userRole), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User_roles $userRole)
    {
        $userRole->load('user', 'role');
        return new UserRoleResource($userRole);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_roles $userRole)
    {
        $userRole->delete();
        return response()->json(null, 204);
    }
}
