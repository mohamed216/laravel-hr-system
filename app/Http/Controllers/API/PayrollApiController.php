<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollApiController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->get();
        return response()->json($payrolls);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020',
            'basic_salary' => 'required|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
        ]);

        $netSalary = $validated['basic_salary'] + ($validated['bonuses'] ?? 0) - ($validated['deductions'] ?? 0);
        $validated['net_salary'] = $netSalary;
        $validated['status'] = 'calculated';

        $payroll = Payroll::create($validated);
        return response()->json($payroll, 201);
    }

    public function show(int $id)
    {
        $payroll = Payroll::with('employee')->find($id);
        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found'], 404);
        }
        return response()->json($payroll);
    }

    public function update(Request $request, int $id)
    {
        $payroll = Payroll::find($id);
        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found'], 404);
        }

        $validated = $request->validate([
            'basic_salary' => 'required|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,calculated,paid',
        ]);

        $netSalary = $validated['basic_salary'] + ($validated['bonuses'] ?? 0) - ($validated['deductions'] ?? 0);
        $validated['net_salary'] = $netSalary;

        $payroll->update($validated);
        return response()->json($payroll);
    }

    public function destroy(int $id)
    {
        $payroll = Payroll::find($id);
        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found'], 404);
        }
        $payroll->delete();
        return response()->json(['message' => 'Payroll deleted']);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020',
        ]);

        $employees = Employee::active()->get();
        $payrolls = [];

        foreach ($employees as $employee) {
            $payrollData = [
                'employee_id' => $employee->id,
                'month' => $validated['month'],
                'year' => $validated['year'],
                'basic_salary' => $employee->salary,
                'bonuses' => 0,
                'deductions' => 0,
                'net_salary' => $employee->salary,
                'status' => 'calculated',
            ];

            $payrolls[] = Payroll::updateOrCreate(
                ['employee_id' => $employee->id, 'month' => $validated['month'], 'year' => $validated['year']],
                $payrollData
            );
        }

        return response()->json(['message' => 'Payroll generated', 'count' => count($payrolls)]);
    }
}
