@extends('layouts.app')

@section('title', __('Admin Reports'))

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4>{{ __('Reports & Analytics') }}</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                <h5>{{ __('Employees Report') }}</h5>
                <p class="text-muted">{{ __('View all employees with filters') }}</p>
                <a href="{{ route('admin.reports.employees') }}" class="btn btn-primary">{{ __('View Report') }}</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-3x text-success mb-3"></i>
                <h5>{{ __('Attendance Report') }}</h5>
                <p class="text-muted">{{ __('Monthly attendance statistics') }}</p>
                <a href="{{ route('admin.reports.attendance') }}" class="btn btn-success">{{ __('View Report') }}</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-money-bill-wave fa-3x text-warning mb-3"></i>
                <h5>{{ __('Payroll Report') }}</h5>
                <p class="text-muted">{{ __('Monthly payroll summary') }}</p>
                <a href="{{ route('admin.reports.payroll') }}" class="btn btn-warning">{{ __('View Report') }}</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-minus fa-3x text-info mb-3"></i>
                <h5>{{ __('Leaves Report') }}</h5>
                <p class="text-muted">{{ __('Leave requests statistics') }}</p>
                <a href="{{ route('admin.reports.leaves') }}" class="btn btn-info">{{ __('View Report') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
