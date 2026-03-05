<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('rtl') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }} - HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @if(session('rtl'))
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @endif
    <style>
        body { background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { max-width: 400px; width: 100%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">{{ __('HR Management System') }}</h3>
                    <h5 class="text-center mb-4">{{ __('Login') }}</h5>
                    
                    @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
