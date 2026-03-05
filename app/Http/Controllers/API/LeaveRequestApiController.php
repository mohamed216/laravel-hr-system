<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestApiController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with(['employee', 'approver'])->get();
        return response()->json($leaves);
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

        $leave = LeaveRequest::create($validated);
        return response()->json($leave, 201);
    }

    public function show(int $id)
    {
        $leave = LeaveRequest::with(['employee', 'approver'])->find($id);
        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }
        return response()->json($leave);
    }

    public function update(Request $request, int $id)
    {
        $leave = LeaveRequest::find($id);
        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        $validated = $request->validate([
            'type' => 'required|in:vacation,sick,unpaid,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required|string',
        ]);

        $leave->update($validated);
        return response()->json($leave);
    }

    public function destroy(int $id)
    {
        $leave = LeaveRequest::find($id);
        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }
        $leave->delete();
        return response()->json(['message' => 'Leave request deleted']);
    }

    public function approve(int $id, Request $request)
    {
        $leave = LeaveRequest::find($id);
        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => $request->user()->employee_id ?? 1,
        ]);

        return response()->json($leave);
    }

    public function reject(int $id, Request $request)
    {
        $leave = LeaveRequest::find($id);
        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->employee_id ?? 1,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return response()->json($leave);
    }
}
