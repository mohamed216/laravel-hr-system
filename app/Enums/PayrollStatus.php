<?php

namespace App\Enums;

enum PayrollStatus: string
{
    case DRAFT = 'draft';
    case CALCULATED = 'calculated';
    case PAID = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('Draft'),
            self::CALCULATED => __('Calculated'),
            self::PAID => __('Paid'),
        };
    }
}
