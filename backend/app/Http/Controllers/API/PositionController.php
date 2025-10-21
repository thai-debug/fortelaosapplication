<?php

namespace App\Http\Controllers\API;

use App\Models\Positions;
use Illuminate\Http\Request;
use App\Http\Resources\PositionResource;

class PositionController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PositionResource::collection(Positions::with('department', 'users')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'level' => 'required|string|max:100',
                'department_id' => 'required|exists:departments,id',
            ]);

            $position = Positions::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Position created successfully.',
                'data' => new PositionResource($position)
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
    public function show(Positions $position)
    {
        $position->load('department', 'users');
        return new PositionResource($position);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Positions $position)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'level' => 'sometimes|required|string|max:100',
            'department_id' => 'sometimes|required|exists:departments,id',
        ]);

        $position->update($validated);
        return response()->json(new PositionResource($position), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Positions $position)
    {
        $position->delete();
        return response()->json(null, 204);
    }
}
