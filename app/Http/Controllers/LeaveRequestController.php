<?php

namespace App\Http\Controllers;

use App\Repositories\LeaveRequestRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    protected $leaveRequestRepository;
    protected $employeeRepository;

    public function __construct(LeaveRequestRepository $leaveRequestRepository, EmployeeRepository $employeeRepository)
    {
        $this->leaveRequestRepository = $leaveRequestRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $leaveRequests = $this->leaveRequestRepository->getAll();
        return view('leave.index', compact('leaveRequests'));
    }

    public function myRequests()
    {
        // For API - get current employee requests
        $leaveRequests = $this->leaveRequestRepository->getAll();
        return view('leave.my', compact('leaveRequests'));
    }

    public function pending()
    {
        $leaveRequests = $this->leaveRequestRepository->getPending();
        return view('leave.pending', compact('leaveRequests'));
    }

    public function create()
    {
        return view('leave.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:vacation,sick,unpaid,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $this->leaveRequestRepository->create($validated);
        return redirect()->route('leave.index')->with('success', __('created_successfully'));
    }

    public function approve(int $id, Request $request)
    {
        $leaveRequest = $this->leaveRequestRepository->getById($id);
        if (!$leaveRequest) {
            return redirect()->route('leave.index')->with('error', __('Leave request not found'));
        }

        // Get current authenticated user as approver (from request or auth)
        $approverId = $request->user()->employee_id ?? 1;
        
        $this->leaveRequestRepository->approve($leaveRequest, $approverId);
        return redirect()->route('leave.pending')->with('success', __('Leave request approved'));
    }

    public function show(int $id)
    {
        $leaveRequest = $this->leaveRequestRepository->getById($id);
        if (!$leaveRequest) {
            return redirect()->route('leave.index')->with('error', __('Leave request not found'));
        }
        return view('leave.show', compact('leaveRequest'));
    }

    public function edit(int $id)
    {
        $leaveRequest = $this->leaveRequestRepository->getById($id);
        if (!$leaveRequest) {
            return redirect()->route('leave.index')->with('error', __('Leave request not found'));
        }
        $employees = $this->employeeRepository->getAll();
        return view('leave.edit', compact('leaveRequest', 'employees'));
    }

    public function update(Request $request, int $id)
    {
        $leaveRequest = $this->leaveRequestRepository->getById($id);
        if (!$leaveRequest) {
            return redirect()->route('leave.index')->with('error', __('Leave request not found'));
        }

        $validated = $request->validate([
            'type' => 'required|in:vacation,sick,unpaid,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $this->leaveRequestRepository->update($leaveRequest, $validated);
        return redirect()->route('leave.index')->with('success', __('updated_successfully'));
    }

    public function reject(int $id, Request $request)
    {
        $leaveRequest = $this->leaveRequestRepository->getById($id);
        if (!$leaveRequest) {
            return redirect()->route('leave.index')->with('error', __('Leave request not found'));
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $approverId = $request->user()->employee_id ?? 1;
        
        $this->leaveRequestRepository->reject($leaveRequest, $approverId, $validated['rejection_reason']);
        return redirect()->route('leave.pending')->with('success', __('Leave request rejected'));
    }

    public function destroy(int $id)
    {
        $leaveRequest = $this->leaveRequestRepository->getById($id);
        if (!$leaveRequest) {
            return redirect()->route('leave.index')->with('error', __('Leave request not found'));
        }

        $this->leaveRequestRepository->delete($leaveRequest);
        return redirect()->route('leave.index')->with('success', __('deleted_successfully'));
    }
}
