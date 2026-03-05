@extends('layouts.app')

@section('title', __('Attendance Details'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Attendance Details') }}</h5>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>{{ __('Employee') }}:</strong> {{ $attendance->employee->name ?? '-' }}</p>
                <p><strong>{{ __('Date') }}:</strong> {{ $attendance->date }}</p>
                <p><strong>{{ __('Check In') }}:</strong> {{ $attendance->check_in ?? '-' }}</p>
                <p><strong>{{ __('Check Out') }}:</strong> {{ $attendance->check_out ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>{{ __('Hours Worked') }}:</strong> {{ $attendance->hours_worked ?? 0 }}</p>
                <p><strong>{{ __('Notes') }}:</strong> {{ $attendance->notes ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
