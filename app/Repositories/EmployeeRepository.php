<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository
{
    public function getAll(): Collection
    {
        return Employee::with(['department', 'position'])->get();
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return Employee::with(['department', 'position'])->paginate($perPage);
    }

    public function getById(int $id): ?Employee
    {
        return Employee::with(['department', 'position'])->find($id);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update($data);
        return $employee->fresh();
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }

    public function getActiveEmployees(): Collection
    {
        return Employee::active()->with(['department', 'position'])->get();
    }

    public function getByDepartment(int $departmentId): Collection
    {
        return Employee::byDepartment($departmentId)->with(['department', 'position'])->get();
    }

    public function search(string $query): Collection
    {
        return Employee::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->get();
    }
}
