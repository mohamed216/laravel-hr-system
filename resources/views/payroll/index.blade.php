@extends('layouts.app')

@section('title', __('Payroll'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="{{ route('payroll.generate') }}" method="POST" class="d-flex gap-2">
        @csrf
        <select name="month" class="form-select" required>
            @for($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>{{ $m }}</option>
            @endfor
        </select>
        <select name="year" class="form-select" required>
            @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
            <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="btn btn-primary">{{ __('Generate Payroll') }}</button>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <th>{{ __('Month') }}</th>
                    <th>{{ __('Year') }}</th>
                    <th>{{ __('Basic Salary') }}</th>
                    <th>{{ __('Bonuses') }}</th>
                    <th>{{ __('Deductions') }}</th>
                    <th>{{ __('Net Salary') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->employee->name ?? '-' }}</td>
                    <td>{{ $payroll->month }}</td>
                    <td>{{ $payroll->year }}</td>
                    <td>{{ number_format($payroll->basic_salary, 2) }}</td>
                    <td>{{ number_format($payroll->bonuses, 2) }}</td>
                    <td>{{ number_format($payroll->deductions, 2) }}</td>
                    <td><strong>{{ number_format($payroll->net_salary, 2) }}</strong></td>
                    <td>
                        <span class="badge bg-{{ $payroll->status == 'paid' ? 'success' : ($payroll->status == 'calculated' ? 'info' : 'secondary') }}">
                            {{ __($payroll->status) }}
                        </span>
                    </td>
                    <td>
                        @if($payroll->status != 'paid')
                        <form action="{{ route('payroll.markPaid', $payroll->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">{{ __('Mark as Paid') }}</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">{{ __('No payroll records found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
