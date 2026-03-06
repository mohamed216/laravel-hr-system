<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee') ?? $this->route('id');
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employeeId,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'birth_date' => 'nullable|date|before:today',
            'national_id' => 'nullable|string|max:50',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,on_leave,terminated',
        ];
    }
}
