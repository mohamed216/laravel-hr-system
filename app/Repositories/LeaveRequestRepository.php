<?php

namespace App\Repositories;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class LeaveRequestRepository
{
    public function getAll(): Collection
    {
        return LeaveRequest::with(['employee', 'approver'])->orderBy('created_at', 'desc')->get();
    }

    public function getById(int $id): ?LeaveRequest
    {
        return LeaveRequest::with(['employee', 'approver'])->find($id);
    }

    public function create(array $data): LeaveRequest
    {
        return LeaveRequest::create($data);
    }

    public function update(LeaveRequest $leaveRequest, array $data): LeaveRequest
    {
        $leaveRequest->update($data);
        return $leaveRequest->fresh();
    }

    public function delete(LeaveRequest $leaveRequest): bool
    {
        return $leaveRequest->delete();
    }

    public function getByEmployee(int $employeeId): Collection
    {
        return LeaveRequest::where('employee_id', $employeeId)->orderBy('created_at', 'desc')->get();
    }

    public function getPending(): Collection
    {
        return LeaveRequest::pending()->with(['employee'])->get();
    }

    public function approve(LeaveRequest $leaveRequest, int $approverId): LeaveRequest
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => $approverId,
        ]);
        return $leaveRequest->fresh();
    }

    public function reject(LeaveRequest $leaveRequest, int $approverId, string $reason): LeaveRequest
    {
        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => $approverId,
            'rejection_reason' => $reason,
        ]);
        return $leaveRequest->fresh();
    }

    public function getApprovedLeaves(Carbon $startDate, Carbon $endDate): Collection
    {
        return LeaveRequest::approved()
            ->where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate)
            ->get();
    }
}
