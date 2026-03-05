@extends('layouts.app')

@section('title', __('Add User'))

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }} *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Email') }} *</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Password') }} *</label>
                <input type="password" name="password" class="form-control" required minlength="8">
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Role') }} *</label>
                <select name="role" class="form-select" required>
                    <option value="admin">{{ __('Admin') }}</option>
                    <option value="hr">{{ __('HR Manager') }}</option>
                    <option value="employee">{{ __('Employee') }}</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Employee') }}</label>
                <select name="employee_id" class="form-select">
                    <option value="">{{ __('Select Employee') }}</option>
                    @foreach(\App\Models\Employee::all() as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
