<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserRoleController;
use App\Http\Controllers\API\EmploymentTypeController;
use App\Http\Controllers\API\PositionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AttendanceRecordController;
use App\Http\Controllers\API\HolidayController;
use App\Http\Controllers\API\LeaveTypeController;
use App\Http\Controllers\API\LeavePolicyController;
use App\Http\Controllers\API\LeaveBalanceController;
use App\Http\Controllers\API\LeaveRequestController;
use App\Http\Controllers\API\LeaveApprovalController;
use App\Http\Controllers\API\OvertimeRequestController;
use App\Http\Controllers\API\OvertimeApprovalController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Public Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Protected Routes (require sanctum auth)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/me', [AuthController::class, 'me']);
//     Route::post('/logout', [AuthController::class, 'logout']);

//     // Include all other API routes under auth
//     Route::apiResource('departments', DepartmentController::class);
//     Route::apiResource('roles', RoleController::class);
//     Route::apiResource('user-roles', UserRoleController::class);
//     Route::apiResource('employment-types', EmploymentTypeController::class);
//     Route::apiResource('positions', PositionController::class);
//     Route::apiResource('users', UserController::class);
//     Route::apiResource('attendance-records', AttendanceRecordController::class);
//     Route::apiResource('holidays', HolidayController::class);
//     Route::apiResource('leave-types', LeaveTypeController::class);
//     Route::apiResource('leave-policies', LeavePolicyController::class);
//     Route::apiResource('leave-balances', LeaveBalanceController::class);
//     Route::apiResource('leave-requests', LeaveRequestController::class);
//     Route::apiResource('leave-approvals', LeaveApprovalController::class);
//     Route::apiResource('overtime-requests', OvertimeRequestController::class);
//     Route::apiResource('overtime-approvals', OvertimeApprovalController::class);
// });


Route::apiResource('departments', DepartmentController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('user-roles', UserRoleController::class);
Route::apiResource('employment-types', EmploymentTypeController::class);
Route::apiResource('positions', PositionController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('attendance-records', AttendanceRecordController::class);
Route::apiResource('holidays', HolidayController::class);
Route::apiResource('leave-types', LeaveTypeController::class);
Route::apiResource('leave-policies', LeavePolicyController::class);
Route::apiResource('leave-balances', LeaveBalanceController::class);
Route::apiResource('leave-requests', LeaveRequestController::class);
Route::apiResource('leave-approvals', LeaveApprovalController::class);
Route::apiResource('overtime-requests', OvertimeRequestController::class);
Route::apiResource('overtime-approvals', OvertimeApprovalController::class);