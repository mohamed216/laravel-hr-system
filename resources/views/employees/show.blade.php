@extends('layouts.app')

@section('title', __('Employee Details'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $employee->name }}</h5>
        <div>
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Personal Information') }}</h6>
                <p><strong>{{ __('Email') }}:</strong> {{ $employee->email }}</p>
                <p><strong>{{ __('Phone') }}:</strong> {{ $employee->phone }}</p>
                <p><strong>{{ __('Address') }}:</strong> {{ $employee->address ?? '-' }}</p>
                <p><strong>{{ __('Birth Date') }}:</strong> {{ $employee->birth_date ?? '-' }}</p>
                <p><strong>{{ __('National ID') }}:</strong> {{ $employee->national_id ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Work Information') }}</h6>
                <p><strong>{{ __('Department') }}:</strong> {{ $employee->department->name ?? '-' }}</p>
                <p><strong>{{ __('Position') }}:</strong> {{ $employee->position->name ?? '-' }}</p>
                <p><strong>{{ __('Salary') }}:</strong> {{ number_format($employee->salary, 2) }}</p>
                <p><strong>{{ __('Hire Date') }}:</strong> {{ $employee->hire_date }}</p>
                <p><strong>{{ __('Status') }}:</strong> 
                    <span class="badge bg-{{ $employee->status == 'active' ? 'success' : 'warning' }}">
                        {{ __($employee->status) }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Emergency Contact') }}</h6>
            </div>
            <div class="col-md-4">
                <p><strong>{{ __('Contact Name') }}:</strong> {{ $employee->emergency_contact_name ?? '-' }}</p>
            </div>
            <div class="col-md-4">
                <p><strong>{{ __('Contact Phone') }}:</strong> {{ $employee->emergency_contact_phone ?? '-' }}</p>
            </div>
            <div class="col-md-4">
                <p><strong>{{ __('Contact Relation') }}:</strong> {{ $employee->emergency_contact_relation ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
