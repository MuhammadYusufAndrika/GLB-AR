<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1D4ED8">

    <title> 3D Product Exhibition</title>

    <style>
        /* =============================================
           PT Dahana – 3D Exhibition  |  White Theme
        ============================================= */
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

        /* ── Navbar ── */
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
            gap: 0.75rem;
            text-decoration: none;
        }
        .navbar-logo {
            width: 40px;
            height: 40px;
            background: var(--red);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .navbar-logo svg { color: #fff; }
        .navbar-name {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.3px;
        }
        .navbar-name span { color: var(--red); }
        .navbar-tagline {
            font-size: 0.7rem;
            color: var(--text-muted);
            display: block;
            font-weight: 400;
            line-height: 1;
        }
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
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
        .navbar-scroll-btn.is-active { background: var(--red); }

        /* ── About Section ── */
        .about-section {
            padding: 5rem 2rem;
            background: #fff;
        }
        .about-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        /* Left – image collage */
        .about-images {
            position: relative;
            height: 420px;
        }
        .about-img-main {
            position: absolute;
            left: 0;
            top: 40px;
            width: 72%;
            height: 360px;
            object-fit: cover;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
        }
        .about-img-inset {
            position: absolute;
            right: 0;
            top: 0;
            width: 46%;
            height: 200px;
            object-fit: cover;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
        }
        /* Red ribbon */
        .about-ribbon {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            background: var(--red);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            padding: 1.25rem 0.55rem;
            border-radius: 0 6px 6px 0;
            z-index: 2;
        }
        /* Placeholder collage when no images */
        .about-images-placeholder {
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0.75rem;
            border-radius: var(--radius);
            overflow: hidden;
        }
        .about-images-placeholder .ph {
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
            border-radius: 8px;
        }
        .about-images-placeholder .ph:first-child {
            grid-row: span 2;
        }

        /* Right – content */
        .about-content {}
        .about-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--blue);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .about-label::before {
            content: '';
            display: inline-block;
            width: 28px;
            height: 3px;
            background: var(--red);
            border-radius: 2px;
        }
        .about-title {
            font-size: 2.25rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            color: var(--text);
        }
        .about-points {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1.125rem;
            margin-bottom: 2rem;
        }
        .about-points li {
            display: flex;
            gap: 0.875rem;
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.6;
        }
        .about-points li .bullet {
            width: 22px;
            height: 22px;
            background: var(--blue);
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .about-points li .bullet svg { color: #fff; }
        .about-points li strong { color: var(--text); font-weight: 700; }
        .discover-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            background: var(--blue);
            color: #fff;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: background var(--ease);
        }
        .discover-btn:hover { background: var(--red-dark); }

        /* ── Stats Bar ── */
        .stats-bar {
            background: var(--red);
            padding: 2rem;
        }
        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            text-align: center;
        }
        .stat-item {}
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 0.3rem;
        }
        .stat-label {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.75);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-divider {
            width: 1px;
            background: rgba(255,255,255,0.2);
        }

        /* ── Gallery Section ── */
        .gallery-section {
            padding: 4rem 2rem;
            background: var(--bg-soft);
        }
        .gallery-inner { max-width: 1200px; margin: 0 auto; }
        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
        }
        .section-title-group {}
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

        /* ── Product Grid ── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        /* ── Product Card ── */
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
            box-shadow: 0 12px 36px rgba(200,16,46,0.14);
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
            0%, 100% { transform: scale(1);   opacity: 0.07; }
            50%       { transform: scale(1.4); opacity: 0.12; }
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
        }
        .view-btn:hover { background: var(--red-dark); }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--text-muted);
        }
        .empty-state svg { width: 68px; height: 68px; color: var(--red); opacity: 0.25; margin-bottom: 1rem; }
        .empty-state h2 { font-size: 1.25rem; color: var(--text); margin-bottom: 0.5rem; }

        /* ── Footer ── */
        .footer {
            background: #1a1a1a;
            color: rgba(255,255,255,0.55);
            text-align: center;
            padding: 1.75rem 2rem;
            font-size: 0.8rem;
        }
        .footer strong { color: #fff; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .about-inner { grid-template-columns: 1fr; gap: 2.5rem; }
            .about-images { height: 280px; }
        }
        @media (max-width: 640px) {
            .about-section { padding: 3rem 1.25rem; }
            .about-title { font-size: 1.75rem; }
            .stats-inner { grid-template-columns: 1fr 1fr; }
            .stat-divider { display: none; }
            .gallery-section { padding: 2.5rem 1.25rem; }
            .section-header { flex-direction: column; align-items: flex-start; }
            .product-grid { grid-template-columns: 1fr; }
            .navbar-inner { padding: 0 1.25rem; }
        }
    </style>
</head>
<body>

    <!-- ── Navbar ── -->
    @include('partials.navbar', ['activePage' => 'home'])

    <!-- ── About / Why Dahana Section ── -->
    <section class="about-section">
        <div class="about-inner">

            <!-- Left: Image collage -->
            <div class="about-images">
                <div class="about-ribbon">50+ Years Experience</div>
                <div class="about-images-placeholder">
                    <div class="ph"></div>
                    <div class="ph">    </div>
                    <div class="ph"></div>
                </div>
            </div>

            <!-- Right: Content -->
            <div class="about-content">
                <div class="about-label">About Us</div>
                {{-- <h2 class="about-title">Why PT</h2> --}}
                <ul class="about-points">
                    <li>
                        <span class="bullet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span><strong>Total Service Solution</strong> Total Service Solution The services of DAHANA are integrated from production of explosives, drilling, and blasting services to other related services, such as demolition, warehousing, consulting and licensing, as well as the mobilization of explosives. For defense such as propellants for large and small munitions, rockets, PETN, and warplane bombs.</span>
                    </li>
                    <li>
                        <span class="bullet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span> 
                        <span><strong>Customization</strong> DAHANA is capable of answering any specific challenge in terms of demand for explosives for a variety of terains and purposes.</span>
                    </li>
                    <li>
                        <span class="bullet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span><strong>Local Content</strong>  DAHANA uses local materials in the country for the products and services it produces. It is a form of our care and support for the independence of the nation industry.</span>
                    </li>
                    <li>
                        <span class="bullet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span><strong>Go Green</strong> Green Concept which is applied to both the management of the buildings and the products have garnered numerous national and international awards.</span>
                    </li>
                </ul>
                <a href="#gallery" class="discover-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 16 12 12 16"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Discover More
                </a>
            </div>
        </div>
    </section>

    <!-- ── Stats Bar ── -->
    {{-- <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Years of Experience</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">1.000+</div>
                <div class="stat-label">Products & Services</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">{{ $products->count() }}</div>
                <div class="stat-label">3D Models Available</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">AR</div>
                <div class="stat-label">Ready Experience</div>
            </div>
        </div>
    </div> --}}

    <!-- ── Product Gallery ── -->
    <section class="gallery-section" id="gallery">
        <div class="gallery-inner">
            <div class="section-header">
                <div class="section-title-group">
                    <div class="section-eyebrow">3D Exhibition</div>
                    <h2 class="section-title">Our Products</h2>
                </div>
                <div class="product-count-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    {{ $products->count() }} products
                </div>
            </div>

            @if($products->isEmpty())
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
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
                                <span class="view-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                                    View in 3D
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- ── Footer ── -->
    <footer class="footer">
        &copy; {{ date('Y') }} <strong>PT Asiklole</strong>. Scan QR codes to view products in Augmented Reality.
    </footer>

</body>
</html>