@extends('layouts.app')

@section('title', __('Payroll Details'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Payroll') }} - {{ $payroll->employee->name ?? '-' }}</h5>
        <a href="{{ route('payroll.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Employee Information') }}</h6>
                <p><strong>{{ __('Employee') }}:</strong> {{ $payroll->employee->name ?? '-' }}</p>
                <p><strong>{{ __('Department') }}:</strong> {{ $payroll->employee->department->name ?? '-' }}</p>
                <p><strong>{{ __('Position') }}:</strong> {{ $payroll->employee->position->name ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Payroll Period') }}</h6>
                <p><strong>{{ __('Month') }}:</strong> {{ $payroll->month }}</p>
                <p><strong>{{ __('Year') }}:</strong> {{ $payroll->year }}</p>
                <p><strong>{{ __('Status') }}:</strong> 
                    <span class="badge bg-{{ $payroll->status == 'paid' ? 'success' : ($payroll->status == 'calculated' ? 'info' : 'secondary') }}">
                        {{ __($payroll->status) }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <h6 class="border-bottom pb-2 mb-3">{{ __('Salary Details') }}</h6>
                <table class="table">
                    <tr>
                        <th>{{ __('Basic Salary') }}</th>
                        <td>{{ number_format($payroll->basic_salary, 2) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Bonuses') }}</th>
                        <td>+ {{ number_format($payroll->bonuses, 2) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Deductions') }}</th>
                        <td>- {{ number_format($payroll->deductions, 2) }}</td>
                    </tr>
                    <tr class="table-primary">
                        <th>{{ __('Net Salary') }}</th>
                        <td><strong>{{ number_format($payroll->net_salary, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($payroll->status != 'paid')
        <div class="mt-4">
            <form action="{{ route('payroll.markPaid', $payroll->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">{{ __('Mark as Paid') }}</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
