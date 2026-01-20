@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>My Profile</h1>
        <p>Update your buyer information</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <form action="{{ route('buyer.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3>Personal Information</h3>
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" value="{{ auth()->user()->name }}" disabled>
                    <small>To change your name, contact admin</small>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="{{ auth()->user()->email }}" disabled>
                    <small>To change your email, contact admin</small>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}" placeholder="09XX XXX XXXX">
                    @error('phone')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3>Delivery Address</h3>
                <p style="color: #666; margin-bottom: 15px;">This will be used as your default delivery address</p>
                
                <div class="form-group">
                    <label for="barangay">Barangay *</label>
                    <input type="text" id="barangay" name="barangay" value="{{ old('barangay', $profile->barangay) }}" required placeholder="e.g., San Jose">
                    @error('barangay')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="municipality">Municipality *</label>
                    <input type="text" id="municipality" name="municipality" value="{{ old('municipality', $profile->municipality) }}" required placeholder="e.g., Bansalan">
                    @error('municipality')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="province">Province</label>
                    <input type="text" id="province" name="province" value="{{ old('province', $profile->province) }}" placeholder="e.g., Davao del Sur">
                    @error('province')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Complete Address</label>
                    <textarea id="address" name="address" rows="2" placeholder="House/Building No., Street, Purok, etc.">{{ old('address', $profile->address) }}</textarea>
                    @error('address')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3>Order Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ $profile->total_transactions ?? 0 }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">₱{{ number_format($profile->total_sales ?? 0, 2) }}</div>
                        <div class="stat-label">Total Spent</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="{{ route('buyer.dashboard') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        color: #2d7a3e;
        margin-bottom: 5px;
    }

    .page-header p {
        color: #666;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 30px;
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e0e0e0;
    }

    .form-section:last-of-type {
        border-bottom: none;
        padding-bottom: 0;
    }

    .form-section h3 {
        color: #2d7a3e;
        margin-bottom: 20px;
        font-size: 18px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-group input:disabled {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    .form-group small {
        display: block;
        margin-top: 5px;
        color: #666;
        font-size: 12px;
    }

    .form-group .error {
        display: block;
        color: #d32f2f;
        font-size: 12px;
        margin-top: 5px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .stat-card {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #2d7a3e;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background-color: #2d7a3e;
        color: white;
    }

    .btn-primary:hover {
        background-color: #1f5529;
    }

    .btn-secondary {
        background-color: #f5f5f5;
        color: #333;
    }

    .btn-secondary:hover {
        background-color: #e0e0e0;
    }
</style>
@endsection
