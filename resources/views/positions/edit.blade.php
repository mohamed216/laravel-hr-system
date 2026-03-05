@extends('layouts.app')

@section('title', isset($position) ? __('Edit Position') : __('Add Position'))

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('positions.update', $position->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">{{ __('Position Name (English)') }} *</label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $position->name_en ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Position Name (Arabic)') }} *</label>
                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar', $position->name_ar ?? '') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Department') }} *</label>
                <select name="department_id" class="form-select" required>
                    <option value="">{{ __('select_department') }}</option>
                    @foreach(\App\Models\Department::all() as $department)
                    <option value="{{ $department->id }}" {{ old('department_id', $position->department_id ?? '') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <a href="{{ route('positions.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
