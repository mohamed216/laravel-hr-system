@extends('layouts.app')

@section('title', __('Performance Reviews'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('performance.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> {{ __('Add Review') }}
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <th>{{ __('Reviewer') }}</th>
                    <th>{{ __('Rating') }}</th>
                    <th>{{ __('Review Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->employee->name ?? '-' }}</td>
                    <td>{{ $review->reviewer->name ?? '-' }}</td>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                    </td>
                    <td>{{ $review->review_date }}</td>
                    <td>
                        <span class="badge bg-{{ $review->status == 'acknowledged' ? 'success' : 'info' }}">
                            {{ __($review->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('performance.show', $review->id) }}" class="btn btn-sm btn-info text-white">{{ __('View') }}</a>
                        <a href="{{ route('performance.edit', $review->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">{{ __('No reviews found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
