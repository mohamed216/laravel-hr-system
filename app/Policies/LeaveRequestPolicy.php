<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;

class LeaveRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isHR() || $user->employee_id !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->isAdmin() || $user->isHR() || $user->employee_id === $leaveRequest->employee_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->employee_id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeaveRequest $leaveRequest): bool
    {
        // Only pending requests can be updated by the owner
        if ($user->employee_id === $leaveRequest->employee_id && $leaveRequest->status === 'pending') {
            return true;
        }
        return $user->isAdmin() || $user->isHR();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeaveRequest $leaveRequest): bool
    {
        // Only pending requests can be deleted by the owner
        if ($user->employee_id === $leaveRequest->employee_id && $leaveRequest->status === 'pending') {
            return true;
        }
        return $user->isAdmin() || $user->isHR();
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user): bool
    {
        return $user->isAdmin() || $user->isHR();
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user): bool
    {
        return $user->isAdmin() || $user->isHR();
    }
}
