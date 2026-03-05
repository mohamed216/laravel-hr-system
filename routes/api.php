<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmployeeApiController;
use App\Http\Controllers\API\AttendanceApiController;
use App\Http\Controllers\API\LeaveRequestApiController;
use App\Http\Controllers\API\PayrollApiController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Language (API)
Route::post('language/switch', [LanguageController::class, 'switch']);

// Authentication
Route::post('login', [EmployeeApiController::class, 'login']);
Route::post('register', [EmployeeApiController::class, 'register']);
Route::post('logout', [EmployeeApiController::class, 'logout'])->middleware('auth:sanctum');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Employees
    Route::apiResource('employees', EmployeeApiController::class);
    
    // Attendance
    Route::apiResource('attendances', AttendanceApiController::class);
    Route::post('attendances/check-in', [AttendanceApiController::class, 'checkIn']);
    Route::post('attendances/check-out', [AttendanceApiController::class, 'checkOut']);
    
    // Leave Requests
    Route::apiResource('leave-requests', LeaveRequestApiController::class);
    Route::post('leave-requests/{id}/approve', [LeaveRequestApiController::class, 'approve']);
    Route::post('leave-requests/{id}/reject', [LeaveRequestApiController::class, 'reject']);
    
    // Payroll
    Route::apiResource('payrolls', PayrollApiController::class);
    Route::post('payrolls/generate', [PayrollApiController::class, 'generate']);
});
