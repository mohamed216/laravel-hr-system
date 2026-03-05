<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository
{
    public function getAll(): Collection
    {
        return Department::with(['manager', 'positions', 'employees'])->get();
    }

    public function getById(int $id): ?Department
    {
        return Department::with(['manager', 'positions', 'employees'])->find($id);
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);
        return $department->fresh();
    }

    public function delete(Department $department): bool
    {
        return $department->delete();
    }

    public function getWithEmployeeCount(): Collection
    {
        return Department::withCount('employees')->get();
    }
}
