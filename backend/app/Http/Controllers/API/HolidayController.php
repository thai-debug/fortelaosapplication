<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\HolidayResource;
use App\Models\Holidays;

class HolidayController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HolidayResource::collection(Holidays::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'holidays_date' => 'required|date|unique:holidays,holidays_date',
            'name' => 'required|string|max:255',
            'is_public' => 'boolean',
        ]);

        $holiday = Holidays::create($validated);
        return response()->json(new HolidayResource($holiday), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Holidays $holiday)
    {
        return new HolidayResource($holiday);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Holidays $holiday)
    {
        $validated = $request->validate([
            'holidays_date' => 'sometimes|required|date|unique:holidays,holidays_date,' . $holiday->id,
            'name' => 'sometimes|required|string|max:255',
            'is_public' => 'boolean',
        ]);

        $holiday->update($validated);
        return response()->json(new HolidayResource($holiday), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holidays $holiday)
    {
        $holiday->delete();
        return response()->json(null, 204);
    }
}
