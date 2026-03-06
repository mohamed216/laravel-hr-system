<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $employees = $this->repository->getAllPaginated(10);
        return view('employees.index', compact('employees'));
    }

    public function show(int $id)
    {
        $employee = $this->repository->getById($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', __('Employee not found'));
        }
        return view('employees.show', compact('employee'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'birth_date' => 'nullable|date',
            'national_id' => 'nullable|string|max:50',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
        ]);

        $this->repository->create($validated);
        return redirect()->route('employees.index')->with('success', __('created_successfully'));
    }

    public function edit(int $id)
    {
        $employee = $this->repository->getById($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', __('Employee not found'));
        }
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, int $id)
    {
        $employee = $this->repository->getById($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', __('Employee not found'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive,on_leave,terminated',
            'birth_date' => 'nullable|date',
            'national_id' => 'nullable|string|max:50',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
        ]);

        $this->repository->update($employee, $validated);
        return redirect()->route('employees.index')->with('success', __('updated_successfully'));
    }

    public function destroy(int $id)
    {
        $employee = $this->repository->getById($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', __('Employee not found'));
        }

        $this->repository->delete($employee);
        return redirect()->route('employees.index')->with('success', __('deleted_successfully'));
    }
}
