<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CCTV PMS') - User Panel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --sidebar-width: 250px;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            padding-top: 20px;
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar-nav {
            list-style: none;
            padding-left: 0;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .sidebar-nav a:hover {
            background-color: rgba(255,255,255,0.1);
            border-left-color: #3498db;
        }
        .sidebar-nav a.active {
            background-color: #3498db;
        }
        .sidebar-nav a i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }
        .top-nav {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-menu .dropdown-toggle::after {
            display: none;
        }
        .page-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h4><i class="fas fa-camera"></i> CCTV PMS</h4>
                <small>User Panel</small>
            </div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('user.purchases.index') }}" class="{{ request()->routeIs('user.purchases.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Purchases</a></li>
                <li><a href="{{ route('user.sales.index') }}" class="{{ request()->routeIs('user.sales.*') ? 'active' : '' }}"><i class="fas fa-hand-holding-usd"></i> Sales</a></li>
                <li><a href="{{ route('user.inventory.index') }}" class="{{ request()->routeIs('user.inventory.*') ? 'active' : '' }}"><i class="fas fa-boxes"></i> Inventory</a></li>
                <li><a href="{{ route('user.payments.index') }}" class="{{ request()->routeIs('user.payments.*') ? 'active' : '' }}"><i class="fas fa-coins"></i> Payments</a></li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <div class="top-nav">
                <div>@yield('page-title', 'Dashboard')</div>
                <div class="user-menu dropdown">
                    <a href="#" class="dropdown-toggle d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="me-2">{{ auth()->user()->name }}</div>
                        <i class="fas fa-user-circle fa-2x"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            </div>
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>