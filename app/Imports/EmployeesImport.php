<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Employee::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'] ?? '',
            'department_id' => $row['department_id'] ?? null,
            'position_id' => $row['position_id'] ?? null,
            'salary' => $row['salary'] ?? 0,
            'hire_date' => $row['hire_date'] ?? now(),
            'status' => $row['status'] ?? 'active',
        ]);
    }
}
