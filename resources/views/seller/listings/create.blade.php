@extends('layouts.app')

@section('title', 'Create Rice Listing')

@section('content')
<div class="card">
    <div class="card-header">Create New Rice Listing</div>
    
    <form action="{{ route('seller.listings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Rice Variety (e.g., C-18, Sinandomeng, Dinorado)</label>
            <input type="text" name="rice_variety" class="form-control" value="{{ old('rice_variety') }}" placeholder="Enter rice type" required>
            @error('rice_variety')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Price per Kilo (₱)</label>
                <input type="number" step="0.01" name="price_per_kg" class="form-control" value="{{ old('price_per_kg') }}" required>
                @error('price_per_kg')
                    <small style="color: #d32f2f;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Quantity Available (kg)</label>
                <input type="number" name="quantity_available" class="form-control" value="{{ old('quantity_available') }}" required>
                @error('quantity_available')
                    <small style="color: #d32f2f;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Location (Barangay, Municipality)</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="e.g., Barangay Centro, Tuguegarao City" required>
            @error('location')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Quality Grade</label>
                <select name="quality_grade" class="form-control" required>
                    <option value="standard" {{ old('quality_grade') === 'standard' ? 'selected' : 'selected' }}>Standard</option>
                    <option value="premium" {{ old('quality_grade') === 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="economy" {{ old('quality_grade') === 'economy' ? 'selected' : '' }}>Economy</option>
                </select>
                @error('quality_grade')
                    <small style="color: #d32f2f;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Harvest Date (Optional)</label>
                <input type="text" name="harvest_date" class="form-control" value="{{ old('harvest_date') }}" placeholder="e.g., December 2025">
                @error('harvest_date')
                    <small style="color: #d32f2f;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Description (Optional)</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Describe your rice product...">{{ old('description') }}</textarea>
            @error('description')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Image (Optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @error('image')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Create Listing</button>
            <a href="{{ route('seller.listings') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
