<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PerformanceReviewController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Language Routes
Route::get('language/{locale}', [LanguageController::class, 'setLocale'])->name('language.switch');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Employees
Route::resource('employees', EmployeeController::class);

// Departments
Route::resource('departments', DepartmentController::class);

// Positions
Route::resource('positions', PositionController::class);
Route::get('positions/department/{departmentId}', [PositionController::class, 'getByDepartment'])->name('positions.byDepartment');

// Attendance
Route::resource('attendance', AttendanceController::class);
Route::get('attendance/today', [AttendanceController::class, 'today'])->name('attendance.today');
Route::get('attendance/employee/{employeeId}', [AttendanceController::class, 'employeeAttendance'])->name('attendance.employee');
Route::post('attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
Route::post('attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');

// Leave Requests
Route::resource('leave', LeaveRequestController::class);
Route::get('leave/pending', [LeaveRequestController::class, 'pending'])->name('leave.pending');
Route::post('leave/{id}/approve', [LeaveRequestController::class, 'approve'])->name('leave.approve');
Route::post('leave/{id}/reject', [LeaveRequestController::class, 'reject'])->name('leave.reject');

// Payroll
Route::resource('payroll', PayrollController::class);
Route::post('payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');
Route::post('payroll/{id}/mark-paid', [PayrollController::class, 'markAsPaid'])->name('payroll.markPaid');

// Performance Reviews
Route::resource('performance', PerformanceReviewController::class);
Route::get('performance/employee/{employeeId}', [PerformanceReviewController::class, 'getByEmployee'])->name('performance.employee');
