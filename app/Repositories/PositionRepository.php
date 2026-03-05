<?php

namespace App\Repositories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

class PositionRepository
{
    public function getAll(): Collection
    {
        return Position::with('department')->get();
    }

    public function getById(int $id): ?Position
    {
        return Position::with('department')->find($id);
    }

    public function create(array $data): Position
    {
        return Position::create($data);
    }

    public function update(Position $position, array $data): Position
    {
        $position->update($data);
        return $position->fresh();
    }

    public function delete(Position $position): bool
    {
        return $position->delete();
    }

    public function getByDepartment(int $departmentId): Collection
    {
        return Position::where('department_id', $departmentId)->get();
    }
}
