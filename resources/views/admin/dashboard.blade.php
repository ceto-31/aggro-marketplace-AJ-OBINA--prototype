@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="card">
    <div class="card-header">Administrator Dashboard</div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_sellers'] }}</div>
            <div class="stat-label">Total Sellers</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['pending_sellers'] }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_buyers'] }}</div>
            <div class="stat-label">Total Buyers</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_listings'] }}</div>
            <div class="stat-label">Rice Listings</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <a href="{{ route('admin.users') }}" class="btn btn-primary" style="text-align: center;">Manage Users</a>
        <a href="{{ route('admin.listings') }}" class="btn btn-primary" style="text-align: center;">View All Listings</a>
        <a href="{{ route('admin.transactions') }}" class="btn btn-primary" style="text-align: center;">View Transactions</a>
        <a href="{{ route('admin.reports') }}" class="btn btn-primary" style="text-align: center;">Generate Reports</a>
    </div>
</div>
@endsection
