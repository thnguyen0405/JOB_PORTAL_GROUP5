<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - CareerVibe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            padding-top: 20px;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
            font-size: 0.95rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
        }
        .sidebar .nav-link i { width: 22px; }
        .sidebar-brand {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            padding: 0 20px 20px;
            display: block;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .top-bar {
            background: #fff;
            padding: 12px 30px;
            margin-left: 250px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="fas fa-briefcase me-2"></i>CareerVibe
        </a>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
               href="{{ route('admin.users') }}">
                <i class="fas fa-users me-2"></i> Users
            </a>
        </nav>
    </div>

    <!-- Top Bar -->
    <div class="top-bar">
        <span class="fw-semibold text-muted">Admin Panel</span>
        <div>
            <span class="me-3 text-muted">{{ Auth::user()->name }}</span>
            <a href="{{ route('account.logout') }}" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>
