@extends('layouts.app')

@section('title', __('Performance Review Details'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Performance Review') }} #{{ $review->id }}</h5>
        <div>
            <a href="{{ route('performance.edit', $review->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            <a href="{{ route('performance.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Review Information') }}</h6>
                <p><strong>{{ __('Employee') }}:</strong> {{ $review->employee->name ?? '-' }}</p>
                <p><strong>{{ __('Reviewer') }}:</strong> {{ $review->reviewer->name ?? '-' }}</p>
                <p><strong>{{ __('Review Date') }}:</strong> {{ $review->review_date }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Rating') }}</h6>
                <p>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    <span class="ms-2">({{ $review->rating }}/5)</span>
                </p>
                <p><strong>{{ __('Status') }}:</strong> 
                    <span class="badge bg-{{ $review->status == 'acknowledged' ? 'success' : 'info' }}">
                        {{ __($review->status) }}
                    </span>
                </p>
            </div>
        </div>
        
        @if($review->comments)
        <div class="row mt-4">
            <div class="col-md-12">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Comments') }}</h6>
                <p>{{ $review->comments }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
