<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1a1a2e">
    
    <title>Product Gallery | WebAR Exhibition</title>
    
    <style>
        /* CSS Variables */
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --secondary-color: #22d3ee;
            --background-dark: #0f0f1a;
            --background-card: #1a1a2e;
            --text-primary: #ffffff;
            --text-secondary: #a1a1aa;
            --border-color: rgba(255, 255, 255, 0.1);
            --border-radius: 16px;
            --transition: 0.3s ease;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--background-dark);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Header */
        .header {
            padding: 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--background-card), var(--background-dark));
            border-bottom: 1px solid var(--border-color);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* Product Card */
        .product-card {
            background: var(--background-card);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: all var(--transition);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: 0 12px 40px rgba(99, 102, 241, 0.25);
        }

        /* ── Rectangular image area ── */
        .product-image {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: linear-gradient(160deg, #1e1e3f 0%, #2a2a4a 100%);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform var(--transition);
        }
        .product-card:hover .product-image img {
            transform: scale(1.04);
        }

        /* Category badge floating over image */
        .product-image .product-category {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            z-index: 2;
            margin: 0;
        }

        /* Placeholder when no poster */
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
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            opacity: 0.12;
            animation: pulse 2.5s ease-in-out infinite;
        }
        .product-image-placeholder::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(15,15,26,0.5) 100%);
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1);   opacity: 0.12; }
            50%       { transform: scale(1.3); opacity: 0.2; }
        }
        .product-image-placeholder svg {
            width: 56px;
            height: 56px;
            color: var(--primary-color);
            position: relative;
            z-index: 1;
            opacity: 0.7;
        }

        /* ── Content section ── */
        .product-content {
            padding: 1.125rem 1.25rem 0.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .product-category {
            display: inline-block;
            padding: 0.2rem 0.65rem;
            background: rgba(99, 102, 241, 0.15);
            color: var(--primary-color);
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            width: fit-content;
        }

        .product-name {
            font-size: 1.0625rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--text-primary);
        }

        .product-description {
            font-size: 0.84rem;
            color: var(--text-secondary);
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
            border-top: 1px solid var(--border-color);
            margin-top: auto;
        }

        .view-ar-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.5rem 1.1rem;
            background: var(--primary-color);
            color: #fff;
            font-size: 0.84rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background var(--transition);
        }
        .view-ar-btn:hover { background: var(--primary-hover); }

        .product-id {
            font-size: 0.7rem;
            color: var(--text-secondary);
            font-family: 'Courier New', monospace;
            background: rgba(255,255,255,0.05);
            padding: 0.2rem 0.45rem;
            border-radius: 4px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            border-top: 1px solid var(--border-color);
            margin-top: 2rem;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .header h1 {
                font-size: 1.5rem;
            }

            .container {
                padding: 1rem;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>🎨 WebAR Exhibition</h1>
        <p>Explore our products in immersive 3D and Augmented Reality</p>
    </header>

    <main class="container">
        @if($products->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <h2>No Products Available</h2>
                <p>Products will appear here once they're added to the exhibition.</p>
            </div>
        @else
            <div class="product-grid">
                @foreach($products as $product)
                    <a href="{{ route('ar.viewer', ['productId' => $product->product_id]) }}" class="product-card">
                        <div class="product-image">
                            @if($product->category)
                                <span class="product-category">{{ $product->category }}</span>
                            @endif
                            @if($product->poster_url)
                                <img src="{{ asset('storage/' . $product->poster_url) }}" alt="{{ $product->product_name }}">
                            @else
                                <div class="product-image-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="product-content">
                            <h2 class="product-name">{{ $product->product_name }}</h2>
                            <p class="product-description">{{ $product->description }}</p>
                        </div>
                        <div class="product-footer">
                            <span class="product-id">{{ $product->product_id }}</span>
                            <span class="view-ar-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                                    <path d="M2 17l10 5 10-5"></path>
                                    <path d="M2 12l10 5 10-5"></path>
                                </svg>
                                View in 3D
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="footer">
        <p>© {{ date('Y') }} WebAR Exhibition System. Scan QR codes to view products in AR.</p>
    </footer>
</body>
</html>
