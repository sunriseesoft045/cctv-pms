<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #34495e;
            --sidebar-width: 250px;
        }
        body {
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
            padding-top: 20px;
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-nav {
            list-style: none;
            padding-left: 0;
        }
        .sidebar-nav a {
            display: block;
            padding: 10px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background-color: rgba(255,255,255,0.1);
        }
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
            <div class="sidebar-brand">
                <h4>User Panel</h4>
            </div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('user.purchases.index') }}" class="{{ request()->routeIs('user.purchases.index') ? 'active' : '' }}"><i class="fas fa-dolly-flatbed"></i> Purchases</a></li>
                <li><a href="{{ route('user.sales.index') }}" class="{{ request()->routeIs('user.sales.index') ? 'active' : '' }}"><i class="fas fa-cart-plus"></i> Sales</a></li>
                <li><a href="{{ route('user.inventory.index') }}" class="{{ request()->routeIs('user.inventory.index') ? 'active' : '' }}"><i class="fas fa-warehouse"></i> Inventory</a></li>
                <li><a href="{{ route('user.payments.index') }}" class="{{ request()->routeIs('user.payments.index') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Payments</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none text-white ps-3"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
