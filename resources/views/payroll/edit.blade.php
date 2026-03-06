@extends('layouts.app')

@section('title', __('Edit Payroll'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Edit Payroll') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('payroll.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <form action="{{ route('payroll.update', $payroll->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Employee') }}</label>
                            <p>{{ $payroll->employee->name ?? '-' }}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Month') }}</label>
                                    <p>{{ $payroll->month }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Year') }}</label>
                                    <p>{{ $payroll->year }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Basic Salary') }} *</label>
                                    <input type="number" name="basic_salary" class="form-control" step="0.01" min="0" value="{{ $payroll->basic_salary }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Bonuses') }}</label>
                                    <input type="number" name="bonuses" class="form-control" step="0.01" min="0" value="{{ $payroll->bonuses }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Deductions') }}</label>
                                    <input type="number" name="deductions" class="form-control" step="0.01" min="0" value="{{ $payroll->deductions }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Net Salary') }}</label>
                            <p class="form-control-static">{{ $payroll->net_salary }}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('payroll.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
