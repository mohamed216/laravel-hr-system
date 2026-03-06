@extends('layouts.app')

@section('title', __('Edit Attendance'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Edit Attendance') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Employee') }}</label>
                            <p>{{ $attendance->employee->name ?? '-' }}</p>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Date') }}</label>
                            <p>{{ $attendance->date }}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Check In Time') }}</label>
                                    <input type="time" name="check_in" class="form-control" value="{{ $attendance->check_in }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Check Out Time') }}</label>
                                    <input type="time" name="check_out" class="form-control" value="{{ $attendance->check_out }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3">{{ $attendance->notes }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
