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
     * get specific holiday
     */
    public function getHolidayByDate($date)
    {
        $specificdate = $date;

        if (! $specificdate) {
            return response()->json(['message' => 'Date is required.'], 400);
        }

        $holiday = Holidays::onDate($specificdate)->first();
        if (!$holiday) {
            return response()->json(['message' => 'Holiday not found.'], 404);
        }
        return response()->json(new HolidayResource($holiday), 200);
    }

    /**
     * get holiday by month
     */
    
    public function getHolidayByMonth(Request $request)
    {
        $month = $request->input('month');
        if (!$month) {
            return response()->json(['message' => 'Month is required.'], 400);
        }
        $holiday = Holidays::whereMonth('holidays_from_date', $month)->get();
        return response()->json(new HolidayResource($holiday), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'holidays_from_date' => 'required|date|unique:holidays,holidays_from_date',
            'holidays_to_date' => 'date',
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
            'holidays_from_date' => 'sometimes|required|date|unique:holidays,holidays_from_date,' . $holiday->id,
            'holidays_to_date' => 'date',
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
