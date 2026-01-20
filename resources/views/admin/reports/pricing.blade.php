@extends('layouts.app')

@section('title', 'Rice Pricing Overview')

@section('content')
<div class="card">
    <div class="card-header">Rice Pricing Overview</div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Rice Variety</th>
                <th>Seller</th>
                <th>Price per Kg</th>
                <th>Quantity Available</th>
                <th>Quality Grade</th>
                <th>Location</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listings as $listing)
            <tr>
                <td>{{ $listing->rice_variety }}</td>
                <td>{{ $listing->seller->name }}</td>
                <td style="color: #2d7a3e; font-weight: bold;">₱{{ number_format($listing->price_per_kg, 2) }}</td>
                <td>{{ $listing->quantity_available }} kg</td>
                <td>{{ ucfirst($listing->quality_grade) }}</td>
                <td>{{ $listing->location }}</td>
                <td>
                    @if($listing->status === 'active')
                        <span class="badge badge-success">Active</span>
                    @elseif($listing->status === 'sold_out')
                        <span class="badge badge-warning">Sold Out</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No rice listings found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 2rem;">
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">Back to Reports</a>
    </div>
</div>
@endsection
