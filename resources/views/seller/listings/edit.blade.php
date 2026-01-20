@extends('layouts.app')

@section('title', 'Edit Rice Listing')

@section('content')
<div class="card">
    <div class="card-header">Edit Rice Listing</div>
    
    <form action="{{ route('seller.listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Rice Variety</label>
            <input type="text" name="rice_variety" class="form-control" value="{{ old('rice_variety', $listing->rice_variety) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Price per Kilo (₱)</label>
                <input type="number" step="0.01" name="price_per_kg" class="form-control" value="{{ old('price_per_kg', $listing->price_per_kg) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Quantity Available (kg)</label>
                <input type="number" name="quantity_available" class="form-control" value="{{ old('quantity_available', $listing->quantity_available) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $listing->location) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Quality Grade</label>
                <select name="quality_grade" class="form-control" required>
                    <option value="standard" {{ old('quality_grade', $listing->quality_grade) === 'standard' ? 'selected' : '' }}>Standard</option>
                    <option value="premium" {{ old('quality_grade', $listing->quality_grade) === 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="economy" {{ old('quality_grade', $listing->quality_grade) === 'economy' ? 'selected' : '' }}>Economy</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $listing->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $listing->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="sold_out" {{ old('status', $listing->status) === 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Harvest Date (Optional)</label>
            <input type="text" name="harvest_date" class="form-control" value="{{ old('harvest_date', $listing->harvest_date) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Description (Optional)</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $listing->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Image (Optional - leave empty to keep current)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update Listing</button>
            <a href="{{ route('seller.listings') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
