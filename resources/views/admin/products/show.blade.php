@extends('admin.layouts.app')

@section('title', $product->product_name)

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $product->product_name }}</h1>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            Edit
        </a>
        <a href="{{ route('ar.viewer', ['productId' => $product->product_id]) }}" class="btn btn-primary" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
            Preview AR
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
    <!-- QR Code Section -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">QR Code</h2>
            <a href="{{ route('admin.products.download-qr', $product) }}" class="btn btn-sm btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Download SVG
            </a>
        </div>
        
        <div style="text-align: center; padding: 1rem;">
            <div class="qr-container">
                {!! $qrCode !!}
            </div>
            
            <div style="margin-top: 1.5rem;">
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Scan this QR code to view in AR</p>
                <code style="background: var(--dark); padding: 0.5rem 1rem; border-radius: var(--radius); font-size: 0.75rem; word-break: break-all;">
                    {{ $viewerUrl }}
                </code>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Product Details</h2>
            @if($product->is_active)
                <span class="badge badge-success">Active</span>
            @else
                <span class="badge badge-warning">Inactive</span>
            @endif
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.25rem;">Product ID</div>
                <code style="background: var(--dark); padding: 0.375rem 0.75rem; border-radius: 4px;">{{ $product->product_id }}</code>
            </div>

            <div>
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.25rem;">Category</div>
                <div>{{ $product->category ?? '-' }}</div>
            </div>

            <div>
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.25rem;">Description</div>
                <div style="line-height: 1.6;">{{ $product->description ?? 'No description provided.' }}</div>
            </div>

            <div>
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.25rem;">3D Model</div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--success);">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    {{ basename($product->model_url) }}
                </div>
            </div>

            @if($product->poster_url)
            <div>
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.25rem;">Poster Image</div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--success);">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    {{ basename($product->poster_url) }}
                </div>
            </div>
            @endif

            <div>
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.25rem;">Created</div>
                <div>{{ $product->created_at->format('M d, Y \a\t H:i') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h2 class="card-title">Analytics</h2>
    </div>
    
    <div class="stats-grid" style="margin-bottom: 0;">
        <div class="stat-card">
            <div class="stat-value">{{ number_format($product->view_count) }}</div>
            <div class="stat-label">Total Views</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($product->ar_activation_count) }}</div>
            <div class="stat-label">AR Activations</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @if($product->view_count > 0)
                    {{ number_format(($product->ar_activation_count / $product->view_count) * 100, 1) }}%
                @else
                    0%
                @endif
            </div>
            <div class="stat-label">AR Conversion Rate</div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h2 class="card-title">Actions</h2>
    </div>
    
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $product->is_active ? 'btn-outline' : 'btn-success' }}">
                @if($product->is_active)
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                        <line x1="12" y1="2" x2="12" y2="12"></line>
                    </svg>
                    Deactivate Product
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Activate Product
                @endif
            </button>
        </form>

        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Delete Product
            </button>
        </form>
    </div>
</div>
@endsection
