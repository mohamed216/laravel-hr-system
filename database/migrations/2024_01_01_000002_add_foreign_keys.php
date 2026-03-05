<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add foreign keys for departments
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('manager_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });

        // Add foreign keys for positions
        Schema::table('positions', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
        });

        // Add foreign keys for employees
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null');
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('set null');
        });

        // Add foreign keys for users
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });

        // Add foreign keys for attendances
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });

        // Add foreign keys for leave_requests
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->foreign('approved_by')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });

        // Add foreign keys for payrolls
        Schema::table('payrolls', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });

        // Add foreign keys for performance_reviews
        Schema::table('performance_reviews', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->foreign('reviewer_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
        });
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['position_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
        });
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['approved_by']);
        });
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
        });
        Schema::table('performance_reviews', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['reviewer_id']);
        });
    }
};
