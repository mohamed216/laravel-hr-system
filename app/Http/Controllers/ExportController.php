<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\LeaveRequest;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportEmployees($format = 'xlsx')
    {
        $filename = 'employees_' . date('Y_m_d_His');
        
        if ($format === 'csv') {
            return Excel::download(new EmployeesExport, $filename . '.csv');
        }
        
        return Excel::download(new EmployeesExport, $filename . '.xlsx');
    }

    public function exportAttendance(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $attendances = Attendance::with('employee')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $data = $attendances->map(function ($att) {
            return [
                'Employee' => $att->employee->name ?? '-',
                'Date' => $att->date,
                'Check In' => $att->check_in,
                'Check Out' => $att->check_out,
                'Hours' => $att->hours_worked,
            ];
        });

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $data;
            
            public function __construct($data)
            {
                $this->data = $data;
            }
            
            public function collection()
            {
                return collect($this->data);
            }
        }, 'attendance_' . $month . '_' . $year . '.xlsx');
    }

    public function exportPayroll(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $payrolls = Payroll::with('employee')
            ->where('month', $month)
            ->where('year', $year)
            ->get();

        $data = $payrolls->map(function ($p) {
            return [
                'Employee' => $p->employee->name ?? '-',
                'Basic Salary' => $p->basic_salary,
                'Bonuses' => $p->bonuses,
                'Deductions' => $p->deductions,
                'Net Salary' => $p->net_salary,
                'Status' => $p->status,
            ];
        });

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $data;
            
            public function __construct($data)
            {
                $this->data = $data;
            }
            
            public function collection()
            {
                return collect($this->data);
            }
        }, 'payroll_' . $month . '_' . $year . '.xlsx');
    }

    public function importEmployees(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new EmployeesImport, $request->file('file'));
        
        return redirect()->route('employees.index')->with('success', 'Employees imported successfully');
    }
}
