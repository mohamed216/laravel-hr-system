@extends('layouts.app')

@section('title', __('Department Details'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $department->name }}</h5>
        <div>
            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Department Information') }}</h6>
                <p><strong>{{ __('Name') }} (EN):</strong> {{ $department->name_en }}</p>
                <p><strong>{{ __('Name') }} (AR):</strong> {{ $department->name_ar }}</p>
                <p><strong>{{ __('Manager') }}:</strong> {{ $department->manager->name ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Statistics') }}</h6>
                <p><strong>{{ __('Employees') }}:</strong> {{ $department->employees->count() ?? 0 }}</p>
                <p><strong>{{ __('Positions') }}:</strong> {{ $department->positions->count() ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
