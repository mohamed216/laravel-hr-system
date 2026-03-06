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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Language Routes
Route::middleware('language')->group(function () {
    Route::get('language/{locale}', [LanguageController::class, 'setLocale'])->name('language.switch');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);

    // Admin Routes (Admin only)
    Route::middleware('App\Http\Middleware\AdminMiddleware')->group(function () {
        // Admin Dashboard
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Users Management
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Reports
        Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/admin/reports/employees', [ReportController::class, 'employees'])->name('admin.reports.employees');
        Route::get('/admin/reports/attendance', [ReportController::class, 'attendance'])->name('admin.reports.attendance');
        Route::get('/admin/reports/payroll', [ReportController::class, 'payroll'])->name('admin.reports.payroll');
        Route::get('/admin/reports/leaves', [ReportController::class, 'leaves'])->name('admin.reports.leaves');
        
        // Settings
        Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::post('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('/admin/settings/clear-cache', [SettingController::class, 'clearCache'])->name('admin.settings.clearCache');
        Route::get('/admin/settings/backup', [SettingController::class, 'backup'])->name('admin.settings.backup');
        
        // Activity Logs
        Route::get('/admin/activity', [ActivityController::class, 'index'])->name('admin.activity');
    });

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
    Route::post('attendance/generate', [AttendanceController::class, 'generate'])->name('attendance.generate');
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
});
});


// Export Routes
Route::get('/export/employees/{format?}', [ExportController::class, 'exportEmployees'])->name('export.employees');
Route::get('/export/attendance', [ExportController::class, 'exportAttendance'])->name('export.attendance');
Route::get('/export/payroll', [ExportController::class, 'exportPayroll'])->name('export.payroll');

// PDF Routes
Route::get('/pdf/employee/{id}', [PdfController::class, 'generateEmployeePdf'])->name('pdf.employee');
Route::get('/pdf/payroll/{id}', [PdfController::class, 'generatePayrollPdf'])->name('pdf.payroll');
Route::get('/pdf/attendance', [PdfController::class, 'generateAttendancePdf'])->name('pdf.attendance');
Route::get('/pdf/payslip/{id}', [PdfController::class, 'generatePayslipPdf'])->name('pdf.payslip');


Route::post('/import/employees', [ExportController::class, 'importEmployees'])->name('import.employees');
