@extends('layouts.app')

@section('title', __('Attendance'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('attendance.today') }}" class="btn btn-primary">{{ __('Today\'s Attendance') }}</a>
    </div>
    <form action="{{ route('attendance.generate') }}" method="POST" class="d-flex gap-2">
        @csrf
        <select name="employee_id" class="form-select">
            <option value="">{{ __('Select Employee') }}</option>
            @foreach(\App\Models\Employee::active()->get() as $employee)
            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>
        <button type="submit" name="action" value="check_in" class="btn btn-success">{{ __('Check In') }}</button>
        <button type="submit" name="action" value="check_out" class="btn btn-warning">{{ __('Check Out') }}</button>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Check In') }}</th>
                    <th>{{ __('Check Out') }}</th>
                    <th>{{ __('Hours Worked') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->employee->name ?? '-' }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->check_in ?? '-' }}</td>
                    <td>{{ $attendance->check_out ?? '-' }}</td>
                    <td>{{ $attendance->hours_worked ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('No attendance records found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
