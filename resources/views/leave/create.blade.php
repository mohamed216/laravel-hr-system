@extends('layouts.app')

@section('title', __('Apply for Leave'))

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('leave.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">{{ __('Employee') }} *</label>
                <select name="employee_id" class="form-select" required>
                    <option value="">{{ __('Select Employee') }}</option>
                    @foreach(\App\Models\Employee::active()->get() as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Leave Type') }} *</label>
                <select name="type" class="form-select" required>
                    <option value="vacation">{{ __('Vacation') }}</option>
                    <option value="sick">{{ __('Sick') }}</option>
                    <option value="unpaid">{{ __('Unpaid') }}</option>
                    <option value="maternity">{{ __('Maternity') }}</option>
                    <option value="paternity">{{ __('Paternity') }}</option>
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Start Date') }} *</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{ __('End Date') }} *</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Reason') }} *</label>
                <textarea name="reason" class="form-control" rows="4" required></textarea>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                <a href="{{ route('leave.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
