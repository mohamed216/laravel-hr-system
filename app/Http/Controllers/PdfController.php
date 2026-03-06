<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Attendance;
use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function generateEmployeePdf($id)
    {
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        
        $pdf = PDF::loadView('pdf.employee', compact('employee'));
        
        return $pdf->download('employee_' . $employee->id . '.pdf');
    }

    public function generatePayrollPdf($id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);
        
        $pdf = PDF::loadView('pdf.payroll', compact('payroll'));
        
        return $pdf->download('payroll_' . $payroll->month . '_' . $payroll->year . '.pdf');
    }

    public function generateAttendancePdf(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $attendances = Attendance::with('employee')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $pdf = PDF::loadView('pdf.attendance', compact('attendances', 'month', 'year'));
        
        return $pdf->download('attendance_' . $month . '_' . $year . '.pdf');
    }

    public function generatePayslipPdf($id)
    {
        $payroll = Payroll::with('employee', 'employee.department')->findOrFail($id);
        
        $pdf = PDF::loadView('pdf.payslip', compact('payroll'));
        
        return $pdf->download('payslip_' . $payroll->employee->name . '_' . $payroll->month . '_' . $payroll->year . '.pdf');
    }
}
