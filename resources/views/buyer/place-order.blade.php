@extends('layouts.app')

@section('title', 'Place Order')

@section('content')
<div class="card">
    <div class="card-header">Place Order</div>
    
    <div style="background-color: #f5f5f5; padding: 1.5rem; border-radius: 6px; margin-bottom: 2rem;">
        <h3 style="color: #2d7a3e; margin-bottom: 1rem;">{{ $listing->rice_variety }}</h3>
        <div style="display: grid; gap: 0.5rem;">
            <div><strong>Seller:</strong> {{ $listing->seller->name }}</div>
            <div><strong>Price per kg:</strong> ₱{{ number_format($listing->price_per_kg, 2) }}</div>
            <div><strong>Available Stock:</strong> {{ $listing->quantity_available }} kg</div>
            <div><strong>Quality Grade:</strong> {{ ucfirst($listing->quality_grade) }}</div>
            <div><strong>Location:</strong> {{ $listing->location }}</div>
        </div>
    </div>

    <form action="{{ route('buyer.place-order.submit', $listing->id) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Quantity (kg)</label>
            <input type="number" name="quantity" class="form-control" min="1" max="{{ $listing->quantity_available }}" value="{{ old('quantity', 1) }}" required>
            @error('quantity')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Delivery Address</label>
            <textarea name="delivery_address" class="form-control" rows="3" required>{{ old('delivery_address') }}</textarea>
            @error('delivery_address')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
            @error('contact_number')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            @error('notes')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Confirm Order</button>
            <a href="{{ route('buyer.browse') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.querySelector('input[name="quantity"]').addEventListener('input', function() {
    const price = {{ $listing->price_per_kg }};
    const quantity = this.value;
    console.log('Total: ₱' + (price * quantity).toFixed(2));
});
</script>
@endsection
