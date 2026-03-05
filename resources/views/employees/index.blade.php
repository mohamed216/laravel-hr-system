@extends('layouts.app')

@section('title', __('Employees'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> {{ __('Add Employee') }}
    </a>
    <form action="{{ route('employees.index') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="{{ __('Search') }}" value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">{{ __('Search') }}</button>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Department') }}</th>
                    <th>{{ __('Position') }}</th>
                    <th>{{ __('Salary') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->department->name ?? '-' }}</td>
                    <td>{{ $employee->position->name ?? '-' }}</td>
                    <td>{{ number_format($employee->salary, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $employee->status == 'active' ? 'success' : ($employee->status == 'on_leave' ? 'warning' : 'secondary') }}">
                            {{ __($employee->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info text-white">{{ __('View') }}</a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('are_you_sure') }}')">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">{{ __('No employees found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $employees->links() }}
</div>
@endsection
