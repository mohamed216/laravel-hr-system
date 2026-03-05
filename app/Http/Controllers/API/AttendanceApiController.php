<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        return response()->json($attendances);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
        ]);

        $attendance = Attendance::create($validated);
        return response()->json($attendance, 201);
    }

    public function show(int $id)
    {
        $attendance = Attendance::with('employee')->find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }
        return response()->json($attendance);
    }

    public function update(Request $request, int $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        $validated = $request->validate([
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $attendance->update($validated);
        return response()->json($attendance);
    }

    public function destroy(int $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }
        $attendance->delete();
        return response()->json(['message' => 'Attendance deleted']);
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $existing = Attendance::where('employee_id', $validated['employee_id'])
            ->where('date', today())
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already checked in today'], 400);
        }

        $attendance = Attendance::create([
            'employee_id' => $validated['employee_id'],
            'date' => today(),
            'check_in' => now()->toTimeString(),
        ]);

        return response()->json($attendance, 201);
    }

    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $attendance = Attendance::where('employee_id', $validated['employee_id'])
            ->where('date', today())
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'No check-in found for today'], 404);
        }

        if ($attendance->check_out) {
            return response()->json(['message' => 'Already checked out today'], 400);
        }

        $attendance->update([
            'check_out' => now()->toTimeString(),
        ]);

        return response()->json($attendance);
    }
}
