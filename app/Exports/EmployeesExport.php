<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::with(['department', 'position'])->get()->map(function ($employee) {
            return [
                'Name' => $employee->name,
                'Email' => $employee->email,
                'Phone' => $employee->phone,
                'Department' => $employee->department?->name,
                'Position' => $employee->position?->name,
                'Salary' => $employee->salary,
                'Status' => $employee->status,
                'Hire Date' => $employee->hire_date,
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Phone', 'Department', 'Position', 'Salary', 'Status', 'Hire Date'];
    }
}
