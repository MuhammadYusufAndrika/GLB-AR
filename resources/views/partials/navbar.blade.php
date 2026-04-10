@php
    $activePage = $activePage ?? null;
@endphp

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="navbar-logo">
                <img src="/logo-navbar.jpg" alt="Logo" class="navbar-logo-image">
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