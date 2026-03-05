@extends('layouts.app')

@section('title', __('Admin Dashboard'))

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ __('Total Users') }}</h6>
                        <h2 class="mb-0">{{ $stats['totalUsers'] }}</h2>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ __('Admins') }}</h6>
                        <h2 class="mb-0">{{ $stats['admins'] }}</h2>
                    </div>
                    <i class="fas fa-user-shield fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ __('HR Managers') }}</h6>
                        <h2 class="mb-0">{{ $stats['hrs'] }}</h2>
                    </div>
                    <i class="fas fa-user-tie fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ __('Employees') }}</h6>
                        <h2 class="mb-0">{{ $stats['employees'] }}</h2>
                    </div>
                    <i class="fas fa-user fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Quick Actions') }}</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users') }}" class="btn btn-primary">
                        <i class="fas fa-users me-2"></i> {{ __('Manage Users') }}
                    </a>
                    <a href="{{ route('employees.index') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i> {{ __('Manage Employees') }}
                    </a>
                    <a href="{{ route('departments.index') }}" class="btn btn-info">
                        <i class="fas fa-building me-2"></i> {{ __('Manage Departments') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('System Info') }}</h5>
            </div>
            <div class="card-body">
                <p><strong>HR System Version:</strong> 1.0.0</p>
                <p><strong>Laravel Version:</strong> 12.x</p>
                <p><strong>PHP Version:</strong> {{ phpversion() }}</p>
                <hr>
                <p class="text-muted">{{ __('Manage system users and their roles.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
