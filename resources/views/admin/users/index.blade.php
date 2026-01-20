@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="card">
    <div class="card-header">User Management</div>
    
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create New User</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge badge-success">{{ ucfirst($user->role) }}</span></td>
                <td>
                    @if($user->status === 'approved')
                        <span class="badge badge-success">Approved</span>
                    @elseif($user->status === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($user->status === 'rejected')
                        <span class="badge badge-danger">Rejected</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    @if($user->status === 'pending')
                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Approve</button>
                        </form>
                        <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Reject</button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                {{ $user->status === 'inactive' ? 'Activate' : 'Deactivate' }}
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No users found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
