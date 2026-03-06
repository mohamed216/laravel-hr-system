@extends('layouts.app')

@section('title', __('Add Payroll'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Add Payroll') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('payroll.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <form action="{{ route('payroll.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('select_employee') }} *</label>
                            <select name="employee_id" class="form-control" required>
                                <option value="">{{ __('select_employee') }}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Month') }} *</label>
                                    <input type="number" name="month" class="form-control" min="1" max="12" value="{{ date('m') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Year') }} *</label>
                                    <input type="number" name="year" class="form-control" min="2020" value="{{ date('Y') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Basic Salary') }} *</label>
                                    <input type="number" name="basic_salary" class="form-control" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Bonuses') }}</label>
                                    <input type="number" name="bonuses" class="form-control" step="0.01" min="0" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Deductions') }}</label>
                                    <input type="number" name="deductions" class="form-control" step="0.01" min="0" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('payroll.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
