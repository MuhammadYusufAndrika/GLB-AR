<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1D4ED8">

    <title>Products | 3D Product Exhibition</title>

    <style>
        :root {
            --red:        #1D4ED8;
            --red-dark:   #1e40af;
            --red-light:  rgba(29,78,216,0.08);
            --bg:         #ffffff;
            --bg-soft:    #f5f6f8;
            --text:       #111827;
            --text-muted: #6b7280;
            --border:     #e5e7eb;
            --blue:       #051d52;
            --shadow-sm:  0 1px 4px rgba(0,0,0,0.06);
            --shadow-md:  0 6px 24px rgba(0,0,0,0.09);
            --radius:     12px;
            --ease:       0.25s ease;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            text-decoration: none;
        }

        .navbar-logo {
            width: 156px;
            height: 46px;
            background: transparent;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .navbar-logo svg { color: #fff; }
        .navbar-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            transform: scale(1.3);
            transform-origin: left center;
        }

        .navbar-tagline {
            font-size: 0.7rem;
            color: var(--text-muted);
            display: block;
            font-weight: 400;
            line-height: 1;
        }

        .navbar-actions {
            display: flex;
            gap: 0.6rem;
            align-items: center;
        }

        .navbar-scroll-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.1rem;
            background: var(--blue);
            color: #fff;
            font-size: 0.84rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background var(--ease);
        }

        .navbar-scroll-btn:hover { background: var(--red-dark); }

        .navbar-scroll-btn.is-active {
            background: var(--red);
        }

        .products-section {
            padding: 3.25rem 2rem 4rem;
            background: var(--bg-soft);
        }

        .products-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            gap: 1rem;
        }

        .section-eyebrow {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--red);
            margin-bottom: 0.3rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text);
        }

        .product-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--red-light);
            color: var(--red);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            margin-bottom: 0.375rem;
        }

        .filter-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            color: var(--text-muted);
            text-decoration: none;
            background: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            transition: all var(--ease);
        }

        .filter-pill:hover {
            border-color: var(--red);
            color: var(--red);
        }

        .filter-pill.is-active {
            background: var(--red);
            border-color: var(--red);
            color: #fff;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
            transition: all var(--ease);
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: var(--red);
            box-shadow: 0 12px 36px rgba(29,78,216,0.14);
        }

        .product-image {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: linear-gradient(160deg, #f5e8ea 0%, #fce8eb 100%);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform var(--ease);
        }

        .product-card:hover .product-image img { transform: scale(1.05); }

        .product-image .product-category {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            z-index: 2;
        }

        .product-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .product-image-placeholder::before {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: var(--red);
            border-radius: 50%;
            opacity: 0.07;
            animation: pulse 2.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.07; }
            50% { transform: scale(1.4); opacity: 0.12; }
        }

        .product-image-placeholder svg {
            width: 52px;
            height: 52px;
            color: var(--red);
            opacity: 0.45;
            position: relative;
            z-index: 1;
        }

        .product-content {
            padding: 1.1rem 1.25rem 0.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .product-category {
            display: inline-block;
            padding: 0.18rem 0.6rem;
            background: var(--red-light);
            color: var(--red);
            font-size: 0.68rem;
            font-weight: 700;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            width: fit-content;
        }

        .product-name {
            font-size: 1.0625rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--text);
        }

        .product-description {
            font-size: 0.84rem;
            color: var(--text-muted);
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 1.25rem;
            border-top: 1px solid var(--border);
            margin-top: auto;
            gap: 0.8rem;
        }

        .product-id {
            font-size: 0.69rem;
            color: #9ca3af;
            font-family: 'Courier New', monospace;
            background: #f3f4f6;
            padding: 0.18rem 0.45rem;
            border-radius: 4px;
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.1rem;
            background: var(--red);
            color: #fff;
            font-size: 0.83rem;
            font-weight: 700;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            transition: background var(--ease);
            text-decoration: none;
            white-space: nowrap;
        }

        .view-btn:hover { background: var(--red-dark); }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--text-muted);
            background: #fff;
            border: 1px dashed var(--border);
            border-radius: var(--radius);
        }

        .empty-state svg {
            width: 68px;
            height: 68px;
            color: var(--red);
            opacity: 0.25;
            margin: 0 auto 1rem;
        }

        .empty-state h2 {
            font-size: 1.25rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .footer {
            background: #1a1a1a;
            color: rgba(255,255,255,0.55);
            text-align: center;
            padding: 1.75rem 2rem;
            font-size: 0.8rem;
        }

        .footer strong { color: #fff; }

        @media (max-width: 640px) {
            .navbar-inner { padding: 0 1.25rem; }
            .products-section { padding: 2.5rem 1.25rem; }
            .section-header { flex-direction: column; align-items: flex-start; }
            .product-grid { grid-template-columns: 1fr; }
            .navbar-actions { gap: 0.35rem; }
            .navbar-scroll-btn { padding: 0.45rem 0.7rem; font-size: 0.75rem; }
            .navbar-brand { gap: 0.2rem; }
            .navbar-logo { width: 126px; height: 38px; }
        }
    </style>
</head>
<body>

    @include('partials.navbar', ['activePage' => 'products'])

    <section class="products-section">
        <div class="products-inner">
            <div class="section-header">
                <div>
                    <div class="section-eyebrow">3D Exhibition</div>
                    <h1 class="section-title">Our Products</h1>
                </div>
                <div class="product-count-badge">{{ $products->count() }} products</div>
            </div>

            <div class="filter-row">
                <a class="filter-pill {{ empty($activeCategory) ? 'is-active' : '' }}" href="{{ route('products.index') }}">All categories</a>
                @foreach($categories as $category)
                    <a class="filter-pill {{ $activeCategory === $category ? 'is-active' : '' }}" href="{{ route('products.index', ['category' => $category]) }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>

            @if($products->isNotEmpty())
                <div class="product-grid">
                    @foreach($products as $product)
                        <article class="product-card">
                            <div class="product-image">
                                <span class="product-category">{{ $product->category ?? 'General' }}</span>
                                @if($product->poster_full_url)
                                    <img src="{{ $product->poster_full_url }}" alt="{{ $product->product_name }}">
                                @else
                                    <div class="product-image-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                            <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                            <line x1="12" y1="22" x2="12" y2="12"></line>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="product-content">
                                <h3 class="product-name">{{ $product->product_name }}</h3>
                                <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>
                            </div>

                            <div class="product-footer">
                                <span class="product-id">{{ $product->product_id }}</span>
                                <a href="{{ route('ar.viewer', ['productId' => $product->product_id]) }}" class="view-btn">View in AR</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 14.15-8.17 8.19a2.25 2.25 0 0 1-3.18 0L3.75 17.2a2.25 2.25 0 0 1 0-3.18l8.17-8.19a2.25 2.25 0 0 1 3.18 0l5.15 5.15a2.25 2.25 0 0 1 0 3.18Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h.01" />
                    </svg>
                    <h2>No products found</h2>
                    <p>Try selecting another category filter.</p>
                </div>
            @endif
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} <strong>3D Product Exhibition</strong> - Category based product listing.</p>
    </footer>

</body>
</html>
