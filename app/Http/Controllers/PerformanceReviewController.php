<?php

namespace App\Http\Controllers;

use App\Repositories\PerformanceReviewRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class PerformanceReviewController extends Controller
{
    protected $reviewRepository;
    protected $employeeRepository;

    public function __construct(PerformanceReviewRepository $reviewRepository, EmployeeRepository $employeeRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $reviews = $this->reviewRepository->getAll();
        return view('performance.index', compact('reviews'));
    }

    public function show(int $id)
    {
        $review = $this->reviewRepository->getById($id);
        if (!$review) {
            return redirect()->route('performance.index')->with('error', __('Review not found'));
        }
        return view('performance.show', compact('review'));
    }

    public function create()
    {
        return view('performance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'reviewer_id' => 'nullable|exists:employees,id',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
            'review_date' => 'required|date',
        ]);

        $validated['status'] = 'submitted';
        
        $this->reviewRepository->create($validated);
        return redirect()->route('performance.index')->with('success', __('created_successfully'));
    }

    public function edit(int $id)
    {
        $review = $this->reviewRepository->getById($id);
        if (!$review) {
            return redirect()->route('performance.index')->with('error', __('Review not found'));
        }
        return view('performance.edit', compact('review'));
    }

    public function update(Request $request, int $id)
    {
        $review = $this->reviewRepository->getById($id);
        if (!$review) {
            return redirect()->route('performance.index')->with('error', __('Review not found'));
        }

        $validated = $request->validate([
            'reviewer_id' => 'nullable|exists:employees,id',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
            'review_date' => 'required|date',
        ]);

        $this->reviewRepository->update($review, $validated);
        return redirect()->route('performance.index')->with('success', __('updated_successfully'));
    }

    public function destroy(int $id)
    {
        $review = $this->reviewRepository->getById($id);
        if (!$review) {
            return redirect()->route('performance.index')->with('error', __('Review not found'));
        }

        $this->reviewRepository->delete($review);
        return redirect()->route('performance.index')->with('success', __('deleted_successfully'));
    }

    public function getByEmployee(int $employeeId)
    {
        $reviews = $this->reviewRepository->getByEmployee($employeeId);
        $employee = $this->employeeRepository->getById($employeeId);
        $averageRating = $this->reviewRepository->getAverageRating($employeeId);
        
        return view('performance.employee', compact('reviews', 'employee', 'averageRating'));
    }
}
