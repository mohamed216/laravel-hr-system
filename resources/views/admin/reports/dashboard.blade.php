@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Admin Dashboard') }}</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>{{ __('Total Employees') }}</h5>
                    <h2>{{ $stats['total_employees'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>{{ __('Active Employees') }}</h5>
                    <h2>{{ $stats['active_employees'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>{{ __('Departments') }}</h5>
                    <h2>{{ $stats['total_departments'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>{{ __('Today Attendance') }}</h5>
                    <h2>{{ $stats['today_attendance'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Recent Employees') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Position') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->department->name ?? '-' }}</td>
                                <td>{{ $employee->position->name ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('No employees found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Pending Leave Requests') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Start Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_leaves as $leave)
                            <tr>
                                <td>{{ $leave->employee->name ?? '-' }}</td>
                                <td>{{ __($leave->leave_type) }}</td>
                                <td>{{ $leave->start_date }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('No pending leaves') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Quick Actions') }}</h5>
                    <a href="{{ route('admin.reports.employees') }}" class="btn btn-primary">{{ __('Employee Reports') }}</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">{{ __('All Reports') }}</a>
                    <a href="{{ route('admin.settings') }}" class="btn btn-info">{{ __('Settings') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
