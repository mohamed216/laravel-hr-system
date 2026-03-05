<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\Department;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function employees(Request $request)
    {
        $query = Employee::with(['department', 'position']);

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $employees = $query->get();
        $departments = Department::all();

        return view('admin.reports.employees', compact('employees', 'departments'));
    }

    public function attendance(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $attendances = Attendance::with('employee')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $stats = [
            'total_days' => $attendances->count(),
            'avg_hours' => $attendances->avg('hours_worked') ?? 0,
            'present' => $attendances->whereNotNull('check_in')->count(),
            'absent' => Employee::active()->count() - $attendances->whereNotNull('check_in')->count(),
        ];

        return view('admin.reports.attendance', compact('attendances', 'stats', 'month', 'year'));
    }

    public function payroll(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $payrolls = Payroll::with('employee')
            ->where('month', $month)
            ->where('year', $year)
            ->get();

        $stats = [
            'total_basic' => $payrolls->sum('basic_salary'),
            'total_bonuses' => $payrolls->sum('bonuses'),
            'total_deductions' => $payrolls->sum('deductions'),
            'total_net' => $payrolls->sum('net_salary'),
            'count' => $payrolls->count(),
        ];

        return view('admin.reports.payroll', compact('payrolls', 'stats', 'month', 'year'));
    }

    public function leaves(Request $request)
    {
        $status = $request->status ?? 'all';
        
        $query = LeaveRequest::with(['employee', 'approver']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $leaves = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'pending' => LeaveRequest::where('status', 'pending')->count(),
            'approved' => LeaveRequest::where('status', 'approved')->count(),
            'rejected' => LeaveRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.leaves', compact('leaves', 'stats', 'status'));
    }

    public function dashboard()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'total_departments' => Department::count(),
            'today_attendance' => Attendance::where('date', today())->count(),
            'pending_leaves' => LeaveRequest::where('status', 'pending')->count(),
            'this_month_payroll' => Payroll::where('month', date('m'))->where('year', date('Y'))->sum('net_salary'),
        ];

        $recent_employees = Employee::latest()->take(5)->get();
        $recent_leaves = LeaveRequest::where('status', 'pending')->with('employee')->take(5)->get();

        return view('admin.reports.dashboard', compact('stats', 'recent_employees', 'recent_leaves'));
    }
}
