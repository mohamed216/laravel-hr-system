@extends('layouts.app')

@section('title', __('Edit Employee') . ' - ' . ($employee->name ?? ''))

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Personal Information') }}</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }} *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name ?? '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Email') }} *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Phone') }} *</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone ?? '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Address') }}</label>
                        <textarea name="address" class="form-control">{{ old('address', $employee->address ?? '') }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Birth Date') }}</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $employee->birth_date ?? '') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('National ID') }}</label>
                        <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $employee->national_id ?? '') }}">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Work Information') }}</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Department') }}</label>
                        <select name="department_id" class="form-select">
                            <option value="">{{ __('select_department') }}</option>
                            @foreach(\App\Models\Department::all() as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Position') }}</label>
                        <select name="position_id" class="form-select">
                            <option value="">{{ __('select_position') }}</option>
                            @foreach(\App\Models\Position::all() as $position)
                            <option value="{{ $position->id }}" {{ old('position_id', $employee->position_id ?? '') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Salary') }} *</label>
                        <input type="number" name="salary" class="form-control" value="{{ old('salary', $employee->salary ?? 0) }}" required step="0.01">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Hire Date') }} *</label>
                        <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $employee->hire_date ?? '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $employee->status ?? '') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status', $employee->status ?? '') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            <option value="on_leave" {{ old('status', $employee->status ?? '') == 'on_leave' ? 'selected' : '' }}>{{ __('On Leave') }}</option>
                            <option value="terminated" {{ old('status', $employee->status ?? '') == 'terminated' ? 'selected' : '' }}>{{ __('Terminated') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="mb-3">{{ __('Emergency Contact') }}</h5>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Contact Name') }}</label>
                        <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $employee->emergency_contact_name ?? '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Contact Phone') }}</label>
                        <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone ?? '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Contact Relation') }}</label>
                        <input type="text" name="emergency_contact_relation" class="form-control" value="{{ old('emergency_contact_relation', $employee->emergency_contact_relation ?? '') }}">
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
