@extends('layouts.app')

@section('title', isset($department) ? __('Edit Department') : __('Add Department'))

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ isset($department) ? route('departments.update', $department->id) : route('departments.store') }}" method="POST">
            @csrf
            @if(isset($department))
            @method('PUT')
            @endif
            
            <div class="mb-3">
                <label class="form-label">{{ __('Department Name (English)') }} *</label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $department->name_en ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Department Name (Arabic)') }} *</label>
                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar', $department->name_ar ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Manager') }}</label>
                <select name="manager_id" class="form-select">
                    <option value="">{{ __('Select Manager') }}</option>
                    @foreach(\App\Models\Employee::all() as $employee)
                    <option value="{{ $employee->id }}" {{ old('manager_id', $department->manager_id ?? '') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
