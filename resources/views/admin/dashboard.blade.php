@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
        Add New Product
    </a>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_products'] }}</div>
        <div class="stat-label">Total Products</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['active_products'] }}</div>
        <div class="stat-label">Active Products</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ number_format($stats['total_views']) }}</div>
        <div class="stat-label">Total Views</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ number_format($stats['total_ar_activations']) }}</div>
        <div class="stat-label">AR Activations</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
    <!-- Recent Products -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recent Products</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline">View All</a>
        </div>
        
        @if($recentProducts->isEmpty())
            <p style="color: var(--text-muted); text-align: center; padding: 2rem;">No products yet. <a href="{{ route('admin.products.create') }}" style="color: var(--primary);">Add your first product</a></p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProducts as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->product_name }}</strong>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $product->product_id }}</div>
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.875rem;">
                            {{ $product->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Top Products -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Top Products by Views</h2>
        </div>
        
        @if($topProducts->isEmpty())
            <p style="color: var(--text-muted); text-align: center; padding: 2rem;">No data available yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Views</th>
                        <th>AR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->product_name }}</strong>
                        </td>
                        <td>{{ number_format($product->view_count) }}</td>
                        <td>{{ number_format($product->ar_activation_count) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- Quick Guide -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h2 class="card-title">Quick Guide</h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        <div>
            <h4 style="margin-bottom: 0.5rem; color: var(--primary);">1. Upload Product</h4>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Upload a .glb or .gltf 3D model file with product details.</p>
        </div>
        <div>
            <h4 style="margin-bottom: 0.5rem; color: var(--primary);">2. Get QR Code</h4>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Download the auto-generated QR code for your product.</p>
        </div>
        <div>
            <h4 style="margin-bottom: 0.5rem; color: var(--primary);">3. Print & Display</h4>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Print the QR code and place it at your exhibition booth.</p>
        </div>
        <div>
            <h4 style="margin-bottom: 0.5rem; color: var(--primary);">4. Track Analytics</h4>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Monitor views and AR activations from the dashboard.</p>
        </div>
    </div>
</div>
@endsection
