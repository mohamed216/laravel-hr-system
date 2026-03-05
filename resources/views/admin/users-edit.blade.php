@extends('layouts.app')

@section('title', __('Edit User'))

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }} *</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Email') }} *</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('New Password') }}</label>
                <input type="password" name="password" class="form-control" minlength="8">
                <small class="text-muted">{{ __('Leave empty to keep current password') }}</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Role') }} *</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                    <option value="hr" {{ $user->role == 'hr' ? 'selected' : '' }}>{{ __('HR Manager') }}</option>
                    <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>{{ __('Employee') }}</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Employee') }}</label>
                <select name="employee_id" class="form-select">
                    <option value="">{{ __('Select Employee') }}</option>
                    @foreach(\App\Models\Employee::all() as $employee)
                    <option value="{{ $employee->id }}" {{ $user->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
