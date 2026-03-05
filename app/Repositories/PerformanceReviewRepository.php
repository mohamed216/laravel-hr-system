<?php

namespace App\Repositories;

use App\Models\PerformanceReview;
use Illuminate\Database\Eloquent\Collection;

class PerformanceReviewRepository
{
    public function getAll(): Collection
    {
        return PerformanceReview::with(['employee', 'reviewer'])->orderBy('review_date', 'desc')->get();
    }

    public function getById(int $id): ?PerformanceReview
    {
        return PerformanceReview::with(['employee', 'reviewer'])->find($id);
    }

    public function create(array $data): PerformanceReview
    {
        return PerformanceReview::create($data);
    }

    public function update(PerformanceReview $review, array $data): PerformanceReview
    {
        $review->update($data);
        return $review->fresh();
    }

    public function delete(PerformanceReview $review): bool
    {
        return $review->delete();
    }

    public function getByEmployee(int $employeeId): Collection
    {
        return PerformanceReview::where('employee_id', $employeeId)
            ->with('reviewer')
            ->orderBy('review_date', 'desc')
            ->get();
    }

    public function getByReviewer(int $reviewerId): Collection
    {
        return PerformanceReview::where('reviewer_id', $reviewerId)
            ->with('employee')
            ->orderBy('review_date', 'desc')
            ->get();
    }

    public function getByRating(int $rating): Collection
    {
        return PerformanceReview::byRating($rating)->with('employee')->get();
    }

    public function getAverageRating(int $employeeId): ?float
    {
        return PerformanceReview::where('employee_id', $employeeId)
            ->avg('rating');
    }
}
