@extends('layouts.app')

@section('title', 'Buyer Activity Report')

@section('content')
<div class="card">
    <div class="card-header">Buyer Activity Report</div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Buyer Name</th>
                <th>Email</th>
                <th>Total Orders</th>
                <th>Status</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buyers as $buyer)
            <tr>
                <td>{{ $buyer->name }}</td>
                <td>{{ $buyer->email }}</td>
                <td>{{ $buyer->purchased_orders_count }}</td>
                <td><span class="badge badge-success">Active</span></td>
                <td>{{ $buyer->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">No buyers found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 2rem;">
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">Back to Reports</a>
    </div>
</div>
@endsection
