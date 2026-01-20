@extends('layouts.app')

@section('title', 'Browse Rice')

@section('content')
<div class="card">
    <div class="card-header">Browse Rice Listings</div>
    
    <form method="GET" action="{{ route('buyer.browse') }}" style="margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <input type="text" name="rice_type" class="form-control" placeholder="Rice Variety (e.g., C-18)" value="{{ request('rice_type') }}">
            </div>
            <div>
                <input type="text" name="barangay" class="form-control" placeholder="Barangay" value="{{ request('barangay') }}">
            </div>
            <div>
                <input type="text" name="municipality" class="form-control" placeholder="Municipality" value="{{ request('municipality') }}">
            </div>
            <div>
                <select name="sort" class="form-control">
                    <option value="">Sort By</option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Filter</button>
            </div>
        </div>
    </form>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($listings as $listing)
        <div class="card" style="padding: 1.5rem;">
            <h3 style="color: #2d7a3e; margin-bottom: 0.5rem;">{{ $listing->rice_variety }}</h3>
            <p style="color: #666; margin-bottom: 1rem;">by {{ $listing->seller->name }}</p>
            
            <div style="margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Price per kg:</span>
                    <strong style="color: #2d7a3e;">₱{{ number_format($listing->price_per_kg, 2) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Available:</span>
                    <strong>{{ $listing->quantity_available }} kg</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Quality:</span>
                    <strong>{{ ucfirst($listing->quality_grade) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Location:</span>
                    <strong>{{ $listing->location }}</strong>
                </div>
            </div>

            @if($listing->description)
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">{{ Str::limit($listing->description, 80) }}</p>
            @endif

            <a href="{{ route('buyer.place-order', $listing->id) }}" class="btn btn-primary" style="width: 100%; text-align: center;">Place Order</a>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
            <p>No rice listings found. Try adjusting your filters.</p>
        </div>
        @endforelse
    </div>

    <div style="margin-top: 2rem;">
        {{ $listings->links() }}
    </div>
</div>
@endsection
