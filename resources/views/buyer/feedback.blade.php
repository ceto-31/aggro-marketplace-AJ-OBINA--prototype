@extends('layouts.app')

@section('title', 'Rate Seller')

@section('content')
<div class="card">
    <div class="card-header">Rate Your Experience</div>
    
    <div style="background-color: #f5f5f5; padding: 1.5rem; border-radius: 6px; margin-bottom: 2rem;">
        <p><strong>Order #:</strong> {{ $order->order_number }}</p>
        <p><strong>Seller:</strong> {{ $order->seller->name }}</p>
        <p><strong>Rice:</strong> {{ $order->riceListing->rice_variety }}</p>
        <p><strong>Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
    </div>

    <form action="{{ route('buyer.feedback.submit', $order->id) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Rating (1-5 stars)</label>
            <select name="rating" class="form-control" required>
                <option value="">Select rating</option>
                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                <option value="4">⭐⭐⭐⭐ Very Good</option>
                <option value="3">⭐⭐⭐ Good</option>
                <option value="2">⭐⭐ Fair</option>
                <option value="1">⭐ Poor</option>
            </select>
            @error('rating')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Comment (Optional)</label>
            <textarea name="comment" class="form-control" rows="4" placeholder="Share your experience with this seller...">{{ old('comment') }}</textarea>
            @error('comment')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
            <a href="{{ route('buyer.orders') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
