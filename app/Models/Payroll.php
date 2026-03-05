<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'month', 'year', 'basic_salary', 'bonuses',
        'deductions', 'net_salary', 'details', 'status'
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'bonuses' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeByMonthYear($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public static function calculateNetSalary(Employee $employee, float $bonuses = 0, float $deductions = 0): float
    {
        return $employee->salary + $bonuses - $deductions;
    }
}
