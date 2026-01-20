@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="card">
    <div class="card-header">Customer Orders</div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Buyer</th>
                <th>Rice Variety</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->buyer->name }}</td>
                <td>{{ $order->riceListing->rice_variety }}</td>
                <td>{{ $order->quantity }} kg</td>
                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                <td>{{ $order->contact_number }}</td>
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
                    @if($order->status !== 'completed')
                        <form action="{{ route('seller.orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('Mark this order as completed?');">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Mark Complete</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center;">No orders yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
