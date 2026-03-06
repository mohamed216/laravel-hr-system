<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PerformanceReviewController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PdfController;

// Clear route cache when accessing
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return redirect('/');
})->name('clear.cache');

// Language Routes
Route::get('language/{locale}', [LanguageController::class, 'setLocale'])->name('language.switch');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);

    // Employees - all logged in users can access
    Route::resource('employees', EmployeeController::class);

    // Departments - admin/HR only
    Route::resource('departments', DepartmentController::class);

    // Positions - admin/HR only
    Route::resource('positions', PositionController::class);

    // Attendance - all logged in
    Route::resource('attendance', AttendanceController::class);

    // Leave Requests - all logged in
    Route::resource('leave', LeaveRequestController::class);
    Route::get('leave/pending', [LeaveRequestController::class, 'pending'])->name('leave.pending');
    Route::post('leave/{id}/approve', [LeaveRequestController::class, 'approve'])->name('leave.approve');
    Route::post('leave/{id}/reject', [LeaveRequestController::class, 'reject'])->name('leave.reject');

    // Attendance - all logged in
    Route::resource('attendance', AttendanceController::class);
    Route::get('attendance/today', [AttendanceController::class, 'today'])->name('attendance.today');
    Route::post('attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
    Route::post('attendance/generate', [AttendanceController::class, 'generate'])->name('attendance.generate');

    // Payroll - admin/HR only
    Route::resource('payroll', PayrollController::class);

    // Performance - admin/HR only
    Route::resource('performance', PerformanceReviewController::class);

    // Export/Import
    Route::get('/export/employees/{format?}', [ExportController::class, 'exportEmployees'])->name('export.employees');
    Route::get('/export/attendance', [ExportController::class, 'exportAttendance'])->name('export.attendance');
    Route::get('/export/payroll', [ExportController::class, 'exportPayroll'])->name('export.payroll');
    Route::post('/import/employees', [ExportController::class, 'importEmployees'])->name('import.employees');

    // PDF
    Route::get('/pdf/employee/{id}', [PdfController::class, 'generateEmployeePdf'])->name('pdf.employee');
    Route::get('/pdf/payroll/{id}', [PdfController::class, 'generatePayrollPdf'])->name('pdf.payroll');
    Route::get('/pdf/attendance', [PdfController::class, 'generateAttendancePdf'])->name('pdf.attendance');
    Route::get('/pdf/payslip/{id}', [PdfController::class, 'generatePayslipPdf'])->name('pdf.payslip');

    // Admin Routes (Admin only)
    Route::middleware('App\Http\Middleware\AdminMiddleware')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Reports
        Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/admin/reports/employees', [ReportController::class, 'employees'])->name('admin.reports.employees');
        
        // Settings
        Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::post('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('/admin/settings/clear-cache', [SettingController::class, 'clearCache'])->name('admin.settings.clearCache');
        
        // Activity Logs
        Route::get('/admin/activity', [ActivityController::class, 'index'])->name('admin.activity');
    });
});
