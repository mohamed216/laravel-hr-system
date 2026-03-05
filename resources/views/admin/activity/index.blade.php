@extends('layouts.app')

@section('title', __('Activity Logs'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>{{ __('System Activity Logs') }}</h4>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted">{{ __('Activity logging helps track user actions in the system.') }}</p>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            {{ __('Logs are stored in: storage/logs/laravel.log') }}
        </div>
        
        <h5 class="mt-4">{{ __('Recent Activities') }}</h5>
        <p class="text-muted">{{ __('Check the application logs for detailed activity information.') }}</p>
        
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Action') }}</th>
                    <th>{{ __('Description') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ now()->format('Y-m-d H:i') }}</td>
                    <td>System</td>
                    <td>{{ __('Activity logging enabled') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
