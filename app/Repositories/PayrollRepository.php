<?php

namespace App\Repositories;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class PayrollRepository
{
    public function getAll(): Collection
    {
        return Payroll::with('employee')->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
    }

    public function getById(int $id): ?Payroll
    {
        return Payroll::with('employee')->find($id);
    }

    public function create(array $data): Payroll
    {
        return Payroll::create($data);
    }

    public function update(Payroll $payroll, array $data): Payroll
    {
        $payroll->update($data);
        return $payroll->fresh();
    }

    public function delete(Payroll $payroll): bool
    {
        return $payroll->delete();
    }

    public function getByEmployee(int $employeeId): Collection
    {
        return Payroll::where('employee_id', $employeeId)->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
    }

    public function getByMonthYear(int $month, int $year): Collection
    {
        return Payroll::byMonthYear($month, $year)->with('employee')->get();
    }

    public function calculatePayroll(Employee $employee, float $bonuses = 0, float $deductions = 0): array
    {
        $netSalary = $employee->salary + $bonuses - $deductions;
        
        return [
            'employee_id' => $employee->id,
            'basic_salary' => $employee->salary,
            'bonuses' => $bonuses,
            'deductions' => $deductions,
            'net_salary' => $netSalary,
            'status' => 'calculated',
        ];
    }

    public function generateMonthlyPayroll(int $month, int $year): Collection
    {
        $employees = Employee::active()->get();
        $payrolls = [];

        foreach ($employees as $employee) {
            $payrollData = $this->calculatePayroll($employee);
            $payrollData['month'] = $month;
            $payrollData['year'] = $year;
            
            $payrolls[] = Payroll::updateOrCreate(
                ['employee_id' => $employee->id, 'month' => $month, 'year' => $year],
                $payrollData
            );
        }

        return Payroll::byMonthYear($month, $year)->with('employee')->get();
    }

    public function markAsPaid(Payroll $payroll): Payroll
    {
        $payroll->update(['status' => 'paid']);
        return $payroll->fresh();
    }
}
