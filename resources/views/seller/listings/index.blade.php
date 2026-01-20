@extends('layouts.app')

@section('title', 'My Rice Listings')

@section('content')
<div class="card">
    <div class="card-header">My Rice Listings</div>
    
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('seller.listings.create') }}" class="btn btn-primary">Add New Rice Listing</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Rice Variety</th>
                <th>Price/kg</th>
                <th>Quantity</th>
                <th>Quality</th>
                <th>Status</th>
                <th>Date Listed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listings as $listing)
            <tr>
                <td>{{ $listing->rice_variety }}</td>
                <td>₱{{ number_format($listing->price_per_kg, 2) }}</td>
                <td>{{ $listing->quantity_available }} {{ $listing->unit }}</td>
                <td>{{ ucfirst($listing->quality_grade) }}</td>
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
                <td>
                    <a href="{{ route('seller.listings.edit', $listing->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Edit</a>
                    <form action="{{ route('seller.listings.delete', $listing->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No listings yet. <a href="{{ route('seller.listings.create') }}">Create your first listing</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
