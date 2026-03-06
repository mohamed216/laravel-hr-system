@extends('layouts.app')

@section('title', __('Position Details'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Position Details') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('positions.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Position Name (English)') }}</label>
                                <p>{{ $position->name_en }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Position Name (Arabic)') }}</label>
                                <p>{{ $position->name_ar }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Department') }}</label>
                                <p>{{ $position->department->name_en ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-primary">
                        {{ __('Edit') }}
                    </a>
                    <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('are_you_sure') }}')">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
