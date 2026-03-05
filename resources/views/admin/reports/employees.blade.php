@extends('layouts.app')

@section('title', __('Employees Report'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>{{ __('Employees Report') }}</h4>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>

<form method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <select name="department_id" class="form-select">
                <option value="">{{ __('All Departments') }}</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">{{ __('All Status') }}</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>{{ __('On Leave') }}</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Department') }}</th>
                    <th>{{ __('Position') }}</th>
                    <th>{{ __('Salary') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->department->name ?? '-' }}</td>
                    <td>{{ $employee->position->name ?? '-' }}</td>
                    <td>{{ number_format($employee->salary, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $employee->status == 'active' ? 'success' : 'warning' }}">
                            {{ __($employee->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">{{ __('No employees found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
