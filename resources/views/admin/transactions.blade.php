@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="card">
    <div class="card-header">All Transactions</div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Buyer</th>
                <th>Seller</th>
                <th>Rice Variety</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->buyer->name }}</td>
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
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">No transactions found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
