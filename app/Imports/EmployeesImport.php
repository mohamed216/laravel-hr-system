<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Employee([
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'] ?? '',
            'department_id' => $row['department_id'] ?? null,
            'position_id' => $row['position_id'] ?? null,
            'salary' => $row['salary'] ?? 0,
            'hire_date' => $row['hire_date'] ?? now()->toDateString(),
            'status' => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive,on_leave,terminated',
        ];
    }
}
