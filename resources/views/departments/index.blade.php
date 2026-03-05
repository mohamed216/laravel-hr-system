@extends('layouts.app')

@section('title', __('Departments'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('departments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> {{ __('Add Department') }}
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Name') }} (EN)</th>
                    <th>{{ __('Name') }} (AR)</th>
                    <th>{{ __('Manager') }}</th>
                    <th>{{ __('Employees') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                <tr>
                    <td>{{ $department->name_en }}</td>
                    <td>{{ $department->name_ar }}</td>
                    <td>{{ $department->manager->name ?? '-' }}</td>
                    <td>{{ $department->employees_count ?? 0 }}</td>
                    <td>
                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-sm btn-info text-white">{{ __('View') }}</a>
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('are_you_sure') }}')">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('No departments found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
