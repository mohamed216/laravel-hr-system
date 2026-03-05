<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $attendanceRepository;
    protected $employeeRepository;

    public function __construct(AttendanceRepository $attendanceRepository, EmployeeRepository $employeeRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $attendances = $this->attendanceRepository->getAll();
        return view('attendance.index', compact('attendances'));
    }

    public function show(int $id)
    {
        $attendance = $this->attendanceRepository->getById($id);
        if (!$attendance) {
            return redirect()->route('attendance.index')->with('error', __('Attendance not found'));
        }
        return view('attendance.show', compact('attendance'));
    }

    public function today()
    {
        $attendances = $this->attendanceRepository->getTodayAttendance();
        return view('attendance.today', compact('attendances'));
    }

    public function employeeAttendance(int $employeeId)
    {
        $attendances = $this->attendanceRepository->getByEmployee($employeeId);
        $employee = $this->employeeRepository->getById($employeeId);
        return view('attendance.employee', compact('attendances', 'employee'));
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        // Check if already checked in today
        $existing = $this->attendanceRepository->getByEmployee($validated['employee_id'])
            ->where('date', today())->first();

        if ($existing) {
            return redirect()->back()->with('error', __('Already checked in today'));
        }

        $this->attendanceRepository->checkIn($validated['employee_id']);
        return redirect()->back()->with('success', __('Check in successful'));
    }

    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $attendance = $this->attendanceRepository->getByEmployee($validated['employee_id'])
            ->where('date', today())->first();

        if (!$attendance) {
            return redirect()->back()->with('error', __('No check-in found for today'));
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', __('Already checked out today'));
        }

        $this->attendanceRepository->checkOut($validated['employee_id'], $attendance->id);
        return redirect()->back()->with('success', __('Check out successful'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $this->attendanceRepository->create($validated);
        return redirect()->route('attendance.index')->with('success', __('created_successfully'));
    }

    public function update(Request $request, int $id)
    {
        $attendance = $this->attendanceRepository->getById($id);
        if (!$attendance) {
            return redirect()->route('attendance.index')->with('error', __('Attendance not found'));
        }

        $validated = $request->validate([
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $this->attendanceRepository->update($attendance, $validated);
        return redirect()->route('attendance.index')->with('success', __('updated_successfully'));
    }

    public function destroy(int $id)
    {
        $attendance = $this->attendanceRepository->getById($id);
        if (!$attendance) {
            return redirect()->route('attendance.index')->with('error', __('Attendance not found'));
        }

        $this->attendanceRepository->delete($attendance);
        return redirect()->route('attendance.index')->with('success', __('deleted_successfully'));
    }
}
