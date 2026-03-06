@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Payroll Report') }}</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label>{{ __('Month') }}</label>
                    <select name="month" class="form-control">
                        @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('Year') }}</label>
                    <select name="year" class="form-control">
                        @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">{{ __('Generate') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Total Employees') }}</h5>
                    <h3>{{ $stats['count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Basic Salary') }}</h5>
                    <h3>{{ number_format($stats['total_basic'], 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Total Bonuses') }}</h5>
                    <h3>{{ number_format($stats['total_bonuses'], 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Net Salary') }}</h5>
                    <h3>{{ number_format($stats['total_net'], 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Employee') }}</th>
                        <th>{{ __('Basic Salary') }}</th>
                        <th>{{ __('Bonuses') }}</th>
                        <th>{{ __('Deductions') }}</th>
                        <th>{{ __('Net Salary') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                    <tr>
                        <td>{{ $payroll->employee->name ?? '-' }}</td>
                        <td>{{ number_format($payroll->basic_salary, 2) }}</td>
                        <td>{{ number_format($payroll->bonuses, 2) }}</td>
                        <td>{{ number_format($payroll->deductions, 2) }}</td>
                        <td>{{ number_format($payroll->net_salary, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : 'warning' }}">
                                {{ __(ucfirst($payroll->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('No records found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
