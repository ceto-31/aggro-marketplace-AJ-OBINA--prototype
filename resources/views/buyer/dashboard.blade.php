@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
<div class="card">
    <div class="card-header">Buyer Dashboard</div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['pending_orders'] }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['completed_orders'] }}</div>
            <div class="stat-label">Completed Orders</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('buyer.browse') }}" class="btn btn-primary" style="text-align: center;">Browse Rice Listings</a>
        <a href="{{ route('buyer.orders') }}" class="btn btn-primary" style="text-align: center;">My Orders</a>
    </div>

    @if($recentOrders->count() > 0)
    <h3 style="margin-bottom: 1rem;">Recent Orders</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Seller</th>
                <th>Rice</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->seller->name }}</td>
                <td>{{ $order->riceListing->rice_variety }}</td>
                <td>{{ $order->quantity }} kg</td>
                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                <td><span class="badge badge-warning">{{ ucfirst($order->status) }}</span></td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
