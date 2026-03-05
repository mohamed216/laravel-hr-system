@extends('layouts.app')

@section('title', __('Leave Request Details'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Leave Request') }} #{{ $leave->id }}</h5>
        <a href="{{ route('leave.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Request Information') }}</h6>
                <p><strong>{{ __('Employee') }}:</strong> {{ $leave->employee->name ?? '-' }}</p>
                <p><strong>{{ __('Leave Type') }}:</strong> {{ __($leave->type) }}</p>
                <p><strong>{{ __('Start Date') }}:</strong> {{ $leave->start_date }}</p>
                <p><strong>{{ __('End Date') }}:</strong> {{ $leave->end_date }}</p>
                <p><strong>{{ __('Days Count') }}:</strong> {{ $leave->days_count }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Status') }}</h6>
                <p><strong>{{ __('Status') }}:</strong> 
                    <span class="badge bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'rejected' ? 'danger' : 'warning') }}">
                        {{ __($leave->status) }}
                    </span>
                </p>
                <p><strong>{{ __('Reason') }}:</strong> {{ $leave->reason }}</p>
                @if($leave->rejection_reason)
                <p><strong>{{ __('Rejection Reason') }}:</strong> {{ $leave->rejection_reason }}</p>
                @endif
            </div>
        </div>
        
        @if($leave->status == 'pending')
        <div class="mt-4">
            <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">{{ __('Approve') }}</button>
            </form>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                {{ __('Reject') }}
            </button>
        </div>
        
        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('leave.reject', $leave->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Reject Leave Request') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Rejection Reason') }} *</label>
                                <textarea name="rejection_reason" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
