@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="card">
    <div class="card-header">My Orders</div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Seller</th>
                <th>Rice Variety</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->seller->name }}</td>
                <td>{{ $order->riceListing->rice_variety }}</td>
                <td>{{ $order->quantity }} kg</td>
                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                <td>
                    @if($order->status === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($order->status === 'completed')
                        <span class="badge badge-success">Completed</span>
                    @else
                        <span class="badge">{{ ucfirst($order->status) }}</span>
                    @endif
                </td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>
                    @if($order->status === 'completed' && !$order->feedback)
                        <a href="{{ route('buyer.feedback', $order->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Rate Seller</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">No orders yet. <a href="{{ route('buyer.browse') }}">Start browsing rice</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
