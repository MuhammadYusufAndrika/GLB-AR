@php
    $activePage = $activePage ?? null;
@endphp

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="navbar-logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <div>
                <span class="navbar-tagline">3D Product Exhibition</span>
            </div>
        </a>

        <div class="navbar-actions">
            <a href="{{ route('home') }}" class="navbar-scroll-btn {{ $activePage === 'home' ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('products.index') }}" class="navbar-scroll-btn {{ $activePage === 'products' ? 'is-active' : '' }}">Products</a>
        </div>
    </div>
</nav>