<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'date', 'check_in', 'check_out', 'hours_worked', 'notes'];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
        'hours_worked' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeToday($query)
    {
        return $query->where('date', today());
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('date', $date);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($attendance) {
            if ($attendance->check_in && $attendance->check_out) {
                $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                $attendance->hours_worked = $checkOut->diffInHours($checkIn);
            }
        });
    }
}
