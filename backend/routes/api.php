<?php

use App\Http\Controllers\API\AttendanceRecordsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('attendance-records', AttendanceRecordsController::class);
    
    // Bulk import route
    Route::post('attendance-records/import', [AttendanceRecordsController::class, 'import']);
});