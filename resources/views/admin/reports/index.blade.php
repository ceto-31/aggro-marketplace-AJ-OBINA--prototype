@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="card">
    <div class="card-header">System Reports</div>
    
    <div style="display: grid; gap: 1.5rem;">
        <a href="{{ route('admin.reports.sellers') }}" class="btn btn-primary" style="text-align: center; padding: 2rem;">
            <h3 style="margin-bottom: 0.5rem;">Seller Activity Report</h3>
            <p style="margin: 0;">View all seller activities and statistics</p>
        </a>
        
        <a href="{{ route('admin.reports.buyers') }}" class="btn btn-primary" style="text-align: center; padding: 2rem;">
            <h3 style="margin-bottom: 0.5rem;">Buyer Activity Report</h3>
            <p style="margin: 0;">View all buyer activities and order history</p>
        </a>
        
        <a href="{{ route('admin.reports.pricing') }}" class="btn btn-primary" style="text-align: center; padding: 2rem;">
            <h3 style="margin-bottom: 0.5rem;">Rice Pricing Overview</h3>
            <p style="margin: 0;">Compare rice prices across all sellers</p>
        </a>
    </div>
</div>
@endsection
