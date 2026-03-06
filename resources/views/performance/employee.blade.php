@extends('layouts.app')

@section('title', __('Performance Reviews') . ' - ' . ($employee->name ?? ''))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Performance Reviews') }} - {{ $employee->name ?? '' }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('performance.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>{{ __('Average Rating') }}:</strong> {{ number_format($averageRating, 1) }} / 5
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Review Date') }}</th>
                                <th>{{ __('Reviewer') }}</th>
                                <th>{{ __('Rating') }}</th>
                                <th>{{ __('Comments') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td>{{ $review->review_date }}</td>
                                    <td>{{ $review->reviewer->name ?? '-' }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </td>
                                    <td>{{ $review->comments ?? '-' }}</td>
                                    <td>{{ __($review->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('No records found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
