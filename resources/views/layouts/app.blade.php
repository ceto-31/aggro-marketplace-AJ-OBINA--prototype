<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPUP Agro Marketplace')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-green: #2d7a3e;
            --light-green: #4CAF50;
            --hover-green: #45a049;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --border-gray: #e0e0e0;
            --text-black: #212121;
            --text-gray: #424242;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-black);
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-green);
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: var(--white);
            font-size: 1.5rem;
            text-decoration: none;
        }

        .navbar-menu {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .navbar-link {
            color: var(--white);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .navbar-link:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .navbar-link.active {
            background-color: rgba(255,255,255,0.2);
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .card-header {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-black);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light-green);
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--light-green);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--hover-green);
        }

        .btn-secondary {
            background-color: var(--text-gray);
            color: var(--white);
        }

        .btn-secondary:hover {
            background-color: var(--text-black);
        }

        .btn-danger {
            background-color: #d32f2f;
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: #b71c1c;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-black);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-gray);
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--light-green);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--white);
        }

        .table th {
            background-color: var(--light-green);
            color: var(--white);
            padding: 1rem;
            text-align: left;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-gray);
        }

        .table tr:hover {
            background-color: var(--light-gray);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 4px solid var(--light-green);
        }

        .stat-value {
            font-size: 2rem;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-gray);
        }

        /* Badge */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.875rem;
            display: inline-block;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
    @yield('styles')
</head>
<body>
    @if(auth()->check())
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="navbar-brand" style="display: flex; align-items: center; gap: 1rem;">
                <img src="{{ asset('spup final logo.png') }}" alt="SPUP Logo" style="height: 40px;">
                <span>SPUP Agro Marketplace</span>
            </a>
            <div class="navbar-menu">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="navbar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="navbar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">Users</a>
                    <a href="{{ route('admin.listings') }}" class="navbar-link {{ request()->routeIs('admin.listings') ? 'active' : '' }}">Listings</a>
                    <a href="{{ route('admin.transactions') }}" class="navbar-link {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">Transactions</a>
                    <a href="{{ route('admin.reports') }}" class="navbar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">Reports</a>
                @elseif(auth()->user()->isSeller())
                    <a href="{{ route('seller.dashboard') }}" class="navbar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('seller.listings') }}" class="navbar-link {{ request()->routeIs('seller.listings*') ? 'active' : '' }}">My Listings</a>
                    <a href="{{ route('seller.orders') }}" class="navbar-link {{ request()->routeIs('seller.orders*') ? 'active' : '' }}">Orders</a>
                    <a href="{{ route('seller.profile') }}" class="navbar-link {{ request()->routeIs('seller.profile') ? 'active' : '' }}">Profile</a>
                @else
                    <a href="{{ route('buyer.dashboard') }}" class="navbar-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('buyer.browse') }}" class="navbar-link {{ request()->routeIs('buyer.browse') ? 'active' : '' }}">Browse Rice</a>
                    <a href="{{ route('buyer.orders') }}" class="navbar-link {{ request()->routeIs('buyer.orders*') ? 'active' : '' }}">My Orders</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="navbar-link" style="background: none; border: none; cursor: pointer; color: white;">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    @endif

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
