@extends('layouts.app')

@section('title', isset($review) ? __('Edit Review') : __('Add Review'))

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('performance.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">{{ __('Employee') }} *</label>
                <select name="employee_id" class="form-select" required>
                    <option value="">{{ __('Select Employee') }}</option>
                    @foreach(\App\Models\Employee::active()->get() as $employee)
                    <option value="{{ $employee->id }}" {{ old('employee_id', $review->employee_id ?? '') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Reviewer') }}</label>
                <select name="reviewer_id" class="form-select">
                    <option value="">{{ __('Select Reviewer') }}</option>
                    @foreach(\App\Models\Employee::active()->get() as $employee)
                    <option value="{{ $employee->id }}" {{ old('reviewer_id', $review->reviewer_id ?? '') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Rating') }} *</label>
                <select name="rating" class="form-select" required>
                    <option value="1" {{ old('rating', $review->rating ?? '') == 1 ? 'selected' : '' }}>1 - {{ __('Poor') }}</option>
                    <option value="2" {{ old('rating', $review->rating ?? '') == 2 ? 'selected' : '' }}>2 - {{ __('Fair') }}</option>
                    <option value="3" {{ old('rating', $review->rating ?? '') == 3 ? 'selected' : '' }}>3 - {{ __('Good') }}</option>
                    <option value="4" {{ old('rating', $review->rating ?? '') == 4 ? 'selected' : '' }}>4 - {{ __('Very Good') }}</option>
                    <option value="5" {{ old('rating', $review->rating ?? '') == 5 ? 'selected' : '' }}>5 - {{ __('Excellent') }}</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Review Date') }} *</label>
                <input type="date" name="review_date" class="form-control" value="{{ old('review_date', $review->review_date ?? date('Y-m-d')) }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ __('Comments') }}</label>
                <textarea name="comments" class="form-control" rows="4">{{ old('comments', $review->comments ?? '') }}</textarea>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <a href="{{ route('performance.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
