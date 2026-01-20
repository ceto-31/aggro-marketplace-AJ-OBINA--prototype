@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="card">
    <div class="card-header">Create New User</div>
    
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="buyer" {{ old('role') === 'buyer' ? 'selected' : '' }}>Buyer</option>
                <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
            @error('role')
                <small style="color: #d32f2f;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
