<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CCTV PMS Admin') - Admin Panel</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --sidebar-width: 250px;
            --dark-bg: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
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
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
        }

        .sidebar-brand small {
            color: #bdc3c7;
            display: block;
            margin-top: 5px;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin: 0;
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
            padding-left: 25px;
        }

        .sidebar-nav a.active {
            background-color: #3498db;
            border-left-color: #2980b9;
            color: white;
        }

        .sidebar-nav a i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .sidebar-divider {
            margin: 15px 0;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }

        /* Top Navigation */
        .top-nav {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #2ecc71);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #3498db;
        }

        /* Page Content */
        .page-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .page-header p {
            color: #7f8c8d;
            margin: 0;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .card-body {
            padding: 20px;
        }

        /* Buttons */
        .btn {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            color: white;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
            color: white;
        }

        /* Form Styling */
        .form-control, .form-select {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        /* Tables */
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: var(--primary-color);
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-color: #f0f0f0;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Status Badge */
        .badge {
            border-radius: 20px;
            padding: 6px 12px;
            font-weight: 500;
            font-size: 12px;
        }

        .badge-active {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-master {
            background-color: #cfe2ff;
            color: #084298;
        }

        .badge-admin {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .badge-user {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        /* Stats Card */
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-card-icon {
            font-size: 32px;
            margin-bottom: 10px;
            height: 50px;
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
            border-radius: 8px;
            background: linear-gradient(135deg, #3498db, #2ecc71);
            color: white;
        }

        .stat-card-title {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-value {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
                width: 100%;
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .page-content {
                padding: 15px;
            }

            .top-nav {
                padding: 10px 15px;
            }

            .nav-title {
                font-size: 16px;
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h4><i class="fas fa-camera"></i> CCTV PMS</h4>
                <small>Admin Panel v1.0</small>
            </div>

            <ul class="sidebar-nav">
                <li>
                    <a href="/admin/dashboard" class="@if(request()->is('admin/dashboard')) active @endif">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Menu items for Admin and Master Admin roles --}}
                @if(auth()->user()->isMasterAdmin() || auth()->user()->isAdmin())
                    <div class="sidebar-divider"></div>
                    <li style="padding: 0 20px; color: #95a5a6; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 10px;">General Management</li>

                    <li>
                        <a href="/admin/admins" class="@if(request()->is('admin/admins*')) active @endif">
                            <i class="fas fa-users-cog"></i>
                            <span>Manage Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/products" class="@if(request()->is('admin/products*')) active @endif">
                            <i class="fas fa-box-open"></i>
                            <span>Products</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/categories" class="@if(request()->is('admin/categories*')) active @endif">
                            <i class="fas fa-tags"></i>
                            <span>Categories</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/units" class="@if(request()->is('admin/units*')) active @endif">
                            <i class="fas fa-ruler-combined"></i>
                            <span>Units</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/inventory" class="@if(request()->is('admin/inventory*')) active @endif">
                            <i class="fas fa-warehouse"></i>
                            <span>Inventory</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/approvals" class="@if(request()->is('admin/approvals*')) active @endif">
                            <i class="fas fa-check-double"></i>
                            <span>Approvals</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/reports" class="@if(request()->is('admin/reports*')) active @endif">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                @endif

                {{-- Master Admin Exclusive Tools --}}
                @if(auth()->user()->isMasterAdmin())
                    <div class="sidebar-divider"></div>
                    <li style="padding: 0 20px; color: #95a5a6; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 10px;">Master Admin Tools</li>

                    <li>
                        <a href="/admin/system-settings" class="@if(request()->is('admin/system-settings*')) active @endif">
                            <i class="fas fa-cogs"></i>
                            <span>System Settings</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/company-profile" class="@if(request()->is('admin/company-profile*')) active @endif">
                            <i class="fas fa-building"></i>
                            <span>Company Profile</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/financial" class="@if(request()->is('admin/financial*')) active @endif">
                            <i class="fas fa-coins"></i>
                            <span>Financial Management</span>
                        </a>
                    </li>
                @endif

                <div class="sidebar-divider" style="margin-top: 30px;"></div>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <div class="top-nav">
                <div class="nav-title">
                    <button class="btn btn-sm btn-link" id="sidebarToggle" style="display: none; margin-right: 10px;">
                        <i class="fas fa-bars"></i>
                    </button>
                    @yield('page-title', 'Dashboard')
                </div>

                <div class="user-menu">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-size: 14px; color: var(--primary-color); margin: 0;">{{ auth()->user()->name }}</div>
                                <small style="color: #7f8c8d; margin: 0;">
                                    @if(auth()->user()->isMasterAdmin())
                                        Master Admin
                                    @elseif(auth()->user()->isAdmin())
                                        Administrator
                                    @else
                                        User
                                    @endif
                                </small>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header">Account</h6></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="fas fa-exclamation-circle"></i> Errors:</strong>
                        <ul style="margin-bottom: 0; margin-top: 10px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (window.innerWidth <= 768) {
                sidebarToggle.style.display = 'block';
            }

            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    sidebarToggle.style.display = 'block';
                } else {
                    sidebarToggle.style.display = 'none';
                    sidebar.classList.remove('show');
                }
            });

            sidebarToggle?.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.sidebar') && !event.target.closest('#sidebarToggle')) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
