@extends('layouts.app')

@section('title', __('Positions'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('positions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> {{ __('Add Position') }}
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Name') }} (EN)</th>
                    <th>{{ __('Name') }} (AR)</th>
                    <th>{{ __('Department') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $position)
                <tr>
                    <td>{{ $position->name_en }}</td>
                    <td>{{ $position->name_ar }}</td>
                    <td>{{ $position->department->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                        <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('are_you_sure') }}')">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">{{ __('No positions found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
