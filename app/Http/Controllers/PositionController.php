<?php

namespace App\Http\Controllers;

use App\Repositories\PositionRepository;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $repository;

    public function __construct(PositionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $positions = $this->repository->getAll();
        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $this->repository->create($validated);
        return redirect()->route('positions.index')->with('success', __('created_successfully'));
    }

    public function edit(int $id)
    {
        $position = $this->repository->getById($id);
        if (!$position) {
            return redirect()->route('positions.index')->with('error', __('Position not found'));
        }
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, int $id)
    {
        $position = $this->repository->getById($id);
        if (!$position) {
            return redirect()->route('positions.index')->with('error', __('Position not found'));
        }

        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $this->repository->update($position, $validated);
        return redirect()->route('positions.index')->with('success', __('updated_successfully'));
    }

    public function destroy(int $id)
    {
        $position = $this->repository->getById($id);
        if (!$position) {
            return redirect()->route('positions.index')->with('error', __('Position not found'));
        }

        $this->repository->delete($position);
        return redirect()->route('positions.index')->with('success', __('deleted_successfully'));
    }

    public function getByDepartment(int $departmentId)
    {
        $positions = $this->repository->getByDepartment($departmentId);
        return response()->json($positions);
    }
}
