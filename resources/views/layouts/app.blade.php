<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('rtl') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('HR Management System') }}</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap RTL -->
    @if(session('rtl'))
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @endif
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6b7280;
        }
        
        body {
            font-family: {{ session('rtl') ? 'Tahoma, Arial, sans-serif' : 'system-ui, -apple-system, sans-serif' }};
        }
        
        .sidebar {
            min-height: 100vh;
            background: #1f2937;
            color: white;
        }
        
        .sidebar a {
            color: #d1d5db;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background: #374151;
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .btn {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3 text-center border-bottom border-secondary">
                    <h5>{{ __('HR Management System') }}</h5>
                </div>
                <nav class="mt-3">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home me-2"></i> {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i> {{ __('Employees') }}
                    </a>
                    <a href="{{ route('departments.index') }}" class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                        <i class="fas fa-building me-2"></i> {{ __('Departments') }}
                    </a>
                    <a href="{{ route('positions.index') }}" class="{{ request()->routeIs('positions.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase me-2"></i> {{ __('Positions') }}
                    </a>
                    <a href="{{ route('attendance.today') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-clock me-2"></i> {{ __('Attendance') }}
                    </a>
                    <a href="{{ route('leave.index') }}" class="{{ request()->routeIs('leave.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-minus me-2"></i> {{ __('Leave Requests') }}
                    </a>
                    <a href="{{ route('payroll.index') }}" class="{{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave me-2"></i> {{ __('Payroll') }}
                    </a>
                    <a href="{{ route('performance.index') }}" class="{{ request()->routeIs('performance.*') ? 'active' : '' }}">
                        <i class="fas fa-star me-2"></i> {{ __('Performance') }}
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Top Bar -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>@yield('title')</h4>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Language Switcher -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-language me-1"></i> {{ __(ucfirst(app()->getLocale())) }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('language.switch', ['locale' => 'en']) }}">{{ __('English') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('language.switch', ['locale' => 'ar']) }}">{{ __('Arabic') }}</a></li>
                            </ul>
                        </div>
                        <!-- User Menu -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i> {{ __('Profile') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">{{ __('Settings') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">{{ __('Logout') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Alerts -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                <!-- Content -->
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
