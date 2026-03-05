<?php

namespace App\Repositories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class AttendanceRepository
{
    public function getAll(): Collection
    {
        return Attendance::with('employee')->get();
    }

    public function getById(int $id): ?Attendance
    {
        return Attendance::with('employee')->find($id);
    }

    public function create(array $data): Attendance
    {
        return Attendance::create($data);
    }

    public function update(Attendance $attendance, array $data): Attendance
    {
        $attendance->update($data);
        return $attendance->fresh();
    }

    public function delete(Attendance $attendance): bool
    {
        return $attendance->delete();
    }

    public function getByEmployee(int $employeeId): Collection
    {
        return Attendance::where('employee_id', $employeeId)->orderBy('date', 'desc')->get();
    }

    public function getByDate(Carbon $date): Collection
    {
        return Attendance::with('employee')->where('date', $date)->get();
    }

    public function getTodayAttendance(): Collection
    {
        return Attendance::with('employee')->today()->get();
    }

    public function checkIn(int $employeeId): Attendance
    {
        return Attendance::create([
            'employee_id' => $employeeId,
            'date' => today(),
            'check_in' => now()->toTimeString(),
        ]);
    }

    public function checkOut(int $employeeId, int $attendanceId): Attendance
    {
        $attendance = Attendance::findOrFail($attendanceId);
        $attendance->update([
            'check_out' => now()->toTimeString(),
        ]);
        return $attendance->fresh();
    }
}
