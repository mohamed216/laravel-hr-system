@extends('layouts.app')

@section('title', __('Today\'s Attendance'))

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <th>{{ __('Department') }}</th>
                    <th>{{ __('Check In') }}</th>
                    <th>{{ __('Check Out') }}</th>
                    <th>{{ __('Hours Worked') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->employee->name ?? '-' }}</td>
                    <td>{{ $attendance->employee->department->name ?? '-' }}</td>
                    <td>{{ $attendance->check_in ?? '-' }}</td>
                    <td>{{ $attendance->check_out ?? '-' }}</td>
                    <td>{{ $attendance->hours_worked ?? 0 }}</td>
                    <td>
                        @if($attendance->check_in && !$attendance->check_out)
                        <span class="badge bg-success">{{ __('Working') }}</span>
                        @elseif($attendance->check_in && $attendance->check_out)
                        <span class="badge bg-info">{{ __('Completed') }}</span>
                        @else
                        <span class="badge bg-warning">{{ __('Not Checked In') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">{{ __('No attendance records for today') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
