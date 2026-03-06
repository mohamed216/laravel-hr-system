<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add indexes for performance
        Schema::table('employees', function (Blueprint $table) {
            $table->index('department_id');
            $table->index('position_id');
            $table->index('status');
            $table->index('hire_date');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('employee_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('date');
            $table->index('employee_id');
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });

        Schema::table('payrolls', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index(['month', 'year']);
            $table->index('status');
        });

        Schema::table('performance_reviews', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index('review_date');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['department_id', 'position_id', 'status', 'hire_date']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'employee_id']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['date', 'employee_id']);
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropIndex(['employee_id', 'status', 'start_date', 'end_date']);
        });

        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropIndex(['employee_id', 'month', 'year', 'status']);
        });

        Schema::table('performance_reviews', function (Blueprint $table) {
            $table->dropIndex(['employee_id', 'review_date']);
        });
    }
};
