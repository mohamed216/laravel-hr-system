<?php

namespace App\Http\Controllers;

use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $repository;

    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
    public function index()
    {
        $departments = $this->repository->getAll();
        return view('departments.index', compact('departments'));
    }

    public function show(int $id)
    {
        $department = $this->repository->getById($id);
        if (!$department) {
            return redirect()->route('departments.index')->with('error', __('Department not found'));
        }
        return view('departments.show', compact('department'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:employees,id',
        ]);

        $this->repository->create($validated);
        return redirect()->route('departments.index')->with('success', __('created_successfully'));
    }

    public function edit(int $id)
    {
        $department = $this->repository->getById($id);
        if (!$department) {
            return redirect()->route('departments.index')->with('error', __('Department not found'));
        }
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, int $id)
    {
        $department = $this->repository->getById($id);
        if (!$department) {
            return redirect()->route('departments.index')->with('error', __('Department not found'));
        }

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:employees,id',
        ]);

        $this->repository->update($department, $validated);
        return redirect()->route('departments.index')->with('success', __('updated_successfully'));
    }

    public function destroy(int $id)
    {
        $department = $this->repository->getById($id);
        if (!$department) {
            return redirect()->route('departments.index')->with('error', __('Department not found'));
        }

        $this->repository->delete($department);
        return redirect()->route('departments.index')->with('success', __('deleted_successfully'));
    }
}
