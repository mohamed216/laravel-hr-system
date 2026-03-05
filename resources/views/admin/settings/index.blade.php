@extends('layouts.app')

@section('title', __('System Settings'))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('General Settings') }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Application Name') }}</label>
                        <input type="text" name="app_name" class="form-control" value="{{ config('app.name') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Default Language') }}</label>
                        <select name="app_locale" class="form-select">
                            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                            <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>{{ __('Arabic') }}</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Timezone') }}</label>
                        <select name="timezone" class="form-select">
                            <option value="UTC">UTC</option>
                            <option value="Africa/Cairo">Africa/Cairo (Egypt)</option>
                            <option value="Asia/Riyadh">Asia/Riyadh (Saudi Arabia)</option>
                            <option value="Europe/London">Europe/London</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Currency') }}</label>
                        <input type="text" name="currency" class="form-control" value="USD">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Daily Work Hours') }}</label>
                        <input type="number" name="work_hours" class="form-control" value="8" min="1" max="24">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">{{ __('Save Settings') }}</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('System Tools') }}</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form method="POST" action="{{ route('admin.settings.clearCache') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-broom me-2"></i> {{ __('Clear Cache') }}
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.settings.backup') }}" class="btn btn-success">
                        <i class="fas fa-database me-2"></i> {{ __('Backup Database') }}
                    </a>
                    
                    <a href="{{ route('admin.activity') }}" class="btn btn-info">
                        <i class="fas fa-history me-2"></i> {{ __('View Activity Logs') }}
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('System Info') }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Laravel:</strong> 12.x</p>
                <p><strong>PHP:</strong> {{ phpversion() }}</p>
                <p><strong>HR System:</strong> 1.0.0</p>
            </div>
        </div>
    </div>
</div>
@endsection
