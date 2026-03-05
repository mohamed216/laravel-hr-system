<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalEmployees' => Employee::count(),
            'activeEmployees' => Employee::where('status', 'active')->count(),
            'onLeave' => Employee::where('status', 'on_leave')->count(),
            'presentToday' => Attendance::today()->whereNotNull('check_in')->count(),
            'pendingLeaveRequests' => LeaveRequest::where('status', 'pending')->count(),
        ];

        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $totalPayroll = Payroll::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('status', 'paid')
            ->sum('net_salary');

        $stats['totalPayroll'] = $totalPayroll;

        $recentEmployees = Employee::latest()->take(5)->get();
        $pendingLeaves = LeaveRequest::pending()->with('employee')->take(5)->get();

        return view('dashboard', compact('stats', 'recentEmployees', 'pendingLeaves'));
    }
}
