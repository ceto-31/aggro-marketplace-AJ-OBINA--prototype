@extends('layouts.app')

@section('title', 'Seller Activity Report')

@section('content')
<div class="card">
    <div class="card-header">Seller Activity Report</div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Seller Name</th>
                <th>Email</th>
                <th>Total Listings</th>
                <th>Total Orders</th>
                <th>Status</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sellers as $seller)
            <tr>
                <td>{{ $seller->name }}</td>
                <td>{{ $seller->email }}</td>
                <td>{{ $seller->rice_listings_count }}</td>
                <td>{{ $seller->sold_orders_count }}</td>
                <td>
                    @if($seller->status === 'approved')
                        <span class="badge badge-success">Active</span>
                    @elseif($seller->status === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @else
                        <span class="badge badge-danger">{{ ucfirst($seller->status) }}</span>
                    @endif
                </td>
                <td>{{ $seller->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No sellers found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 2rem;">
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">Back to Reports</a>
    </div>
</div>
@endsection
