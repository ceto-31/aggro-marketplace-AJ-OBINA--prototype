@extends('layouts.app')

@section('title', 'All Listings')

@section('content')
<div class="card">
    <div class="card-header">All Rice Listings</div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Rice Variety</th>
                <th>Seller</th>
                <th>Price/kg</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Status</th>
                <th>Date Listed</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listings as $listing)
            <tr>
                <td>{{ $listing->rice_variety }}</td>
                <td>{{ $listing->seller->name }}</td>
                <td>₱{{ number_format($listing->price_per_kg, 2) }}</td>
                <td>{{ $listing->quantity_available }} {{ $listing->unit }}</td>
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
                <td>{{ $listing->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No listings found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
