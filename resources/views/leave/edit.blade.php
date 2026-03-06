@extends('layouts.app')

@section('title', __('Edit Leave Request'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Edit Leave Request') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('leave.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <form action="{{ route('leave.update', $leaveRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('select_employee') }} *</label>
                            <select name="employee_id" class="form-control" required>
                                <option value="">{{ __('select_employee') }}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $leaveRequest->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Leave Type') }} *</label>
                            <select name="type" class="form-control" required>
                                <option value="vacation" {{ $leaveRequest->type == 'vacation' ? 'selected' : '' }}>{{ __('Vacation') }}</option>
                                <option value="sick" {{ $leaveRequest->type == 'sick' ? 'selected' : '' }}>{{ __('Sick') }}</option>
                                <option value="unpaid" {{ $leaveRequest->type == 'unpaid' ? 'selected' : '' }}>{{ __('Unpaid') }}</option>
                                <option value="maternity" {{ $leaveRequest->type == 'maternity' ? 'selected' : '' }}>{{ __('Maternity') }}</option>
                                <option value="paternity" {{ $leaveRequest->type == 'paternity' ? 'selected' : '' }}>{{ __('Paternity') }}</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Start Date') }} *</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $leaveRequest->start_date }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('End Date') }} *</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $leaveRequest->end_date }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Reason') }} *</label>
                            <textarea name="reason" class="form-control" rows="3" required>{{ $leaveRequest->reason }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('leave.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
