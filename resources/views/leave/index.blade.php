@extends('layouts.app')

@section('title', __('Leave Requests'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('leave.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> {{ __('Apply for Leave') }}
    </a>
    <a href="{{ route('leave.pending') }}" class="btn btn-warning">{{ __('Pending Requests') }}</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Days') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaveRequests as $leave)
                <tr>
                    <td>{{ $leave->employee->name ?? '-' }}</td>
                    <td>{{ __($leave->type) }}</td>
                    <td>{{ $leave->start_date }}</td>
                    <td>{{ $leave->end_date }}</td>
                    <td>{{ $leave->days_count }}</td>
                    <td>
                        <span class="badge bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ __($leave->status) }}
                        </span>
                    </td>
                    <td>
                        @if($leave->status == 'pending')
                        <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">{{ __('Approve') }}</button>
                        </form>
                        @endif
                        <a href="{{ route('leave.show', $leave->id) }}" class="btn btn-sm btn-info text-white">{{ __('View') }}</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">{{ __('No leave requests found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
