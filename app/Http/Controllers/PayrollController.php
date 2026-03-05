<?php

namespace App\Http\Controllers;

use App\Repositories\PayrollRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected $payrollRepository;
    protected $employeeRepository;

    public function __construct(PayrollRepository $payrollRepository, EmployeeRepository $employeeRepository)
    {
        $this->payrollRepository = $payrollRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $payrolls = $this->payrollRepository->getAll();
        return view('payroll.index', compact('payrolls'));
    }

    public function show(int $id)
    {
        $payroll = $this->payrollRepository->getById($id);
        if (!$payroll) {
            return redirect()->route('payroll.index')->with('error', __('Payroll not found'));
        }
        return view('payroll.show', compact('payroll'));
    }

    public function create()
    {
        return view('payroll.create');
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

        $netSalary = $this->payrollRepository->calculatePayroll(
            $this->employeeRepository->getById($validated['employee_id']),
            $validated['bonuses'] ?? 0,
            $validated['deductions'] ?? 0
        );

        $validated['net_salary'] = $netSalary;
        $validated['status'] = 'calculated';

        $this->payrollRepository->create($validated);
        return redirect()->route('payroll.index')->with('success', __('created_successfully'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020',
        ]);

        $payrolls = $this->payrollRepository->generateMonthlyPayroll(
            $validated['month'],
            $validated['year']
        );

        return redirect()->route('payroll.index')->with('success', __('Payroll generated successfully'));
    }

    public function markAsPaid(int $id)
    {
        $payroll = $this->payrollRepository->getById($id);
        if (!$payroll) {
            return redirect()->route('payroll.index')->with('error', __('Payroll not found'));
        }

        $this->payrollRepository->markAsPaid($payroll);
        return redirect()->route('payroll.index')->with('success', __('Payroll marked as paid'));
    }

    public function destroy(int $id)
    {
        $payroll = $this->payrollRepository->getById($id);
        if (!$payroll) {
            return redirect()->route('payroll.index')->with('error', __('Payroll not found'));
        }

        $this->payrollRepository->delete($payroll);
        return redirect()->route('payroll.index')->with('success', __('deleted_successfully'));
    }
}
