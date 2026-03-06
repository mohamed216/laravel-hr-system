@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Attendance Report') }}</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label>{{ __('Month') }}</label>
                    <select name="month" class="form-control">
                        @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('Year') }}</label>
                    <select name="year" class="form-control">
                        @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">{{ __('Generate') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Total Days') }}</h5>
                    <h3>{{ $stats['total_days'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Average Hours') }}</h5>
                    <h3>{{ round($stats['avg_hours'], 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Present') }}</h5>
                    <h3>{{ $stats['present'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Absent') }}</h5>
                    <h3>{{ $stats['absent'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
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
                        <td>{{ $attendance->hours_worked ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">{{ __('No records found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
