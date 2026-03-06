@extends('layouts.app')

@section('title', __('Add Attendance'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Add Attendance') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <form action="{{ route('attendance.store') }}" method="POST">
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
                        <div class="form-group">
                            <label>{{ __('Date') }} *</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Check In Time') }}</label>
                                    <input type="time" name="check_in" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Check Out Time') }}</label>
                                    <input type="time" name="check_out" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
