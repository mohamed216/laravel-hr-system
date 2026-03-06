<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login']);
    }

    public function index()
    {
        $employees = Employee::with(['department', 'position'])->get();
        return EmployeeResource::collection($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
        ]);

        $employee = Employee::create($validated);
        return response()->json($employee, 201);
    }

    public function show(int $id)
    {
        $employee = Employee::with(['department', 'position'])->find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return new EmployeeResource($employee);
    }

    public function update(Request $request, int $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive,on_leave,terminated',
        ]);

        $employee->update($validated);
        return new EmployeeResource($employee->fresh(['department', 'position']));
    }

    public function destroy(int $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->delete();
        return response()->json(['message' => 'Employee deleted']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return response()->json(['message' => 'Use web auth']);
    }
}
