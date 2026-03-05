<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceReview extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'reviewer_id', 'rating', 'comments', 'review_date', 'status'];

    protected $casts = [
        'rating' => 'integer',
        'review_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'reviewer_id');
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    public function getRatingLabelAttribute(): string
    {
        return match($this->rating) {
            1 => __('Poor'),
            2 => __('Fair'),
            3 => __('Good'),
            4 => __('Very Good'),
            5 => __('Excellent'),
            default => __('Unknown'),
        };
    }
}
