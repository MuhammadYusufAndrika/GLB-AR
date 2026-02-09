<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1a1a2e">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Interactive 3D product viewer with AR capabilities">
    <meta name="robots" content="index, follow">
    
    <!-- iOS Meta Tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <title id="page-title">3D Product Viewer | WebAR Exhibition</title>
    
    <!-- Preload model-viewer -->
    <link rel="modulepreload" href="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js">
    
    <!-- Model Viewer Component -->
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/ar-viewer.css') }}">
</head>
<body>
    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-content">
            <div class="spinner"></div>
            <p class="loading-text">Loading 3D Model...</p>
            <div class="loading-progress">
                <div class="progress-bar" id="progress-bar"></div>
            </div>
            <p class="loading-percent" id="loading-percent">0%</p>
        </div>
    </div>

    <!-- Error Screen -->
    <div id="error-screen" class="error-screen hidden">
        <div class="error-content">
            <div class="error-icon">⚠️</div>
            <h2 class="error-title">Product Not Found</h2>
            <p class="error-message" id="error-message">The requested product could not be loaded.</p>
            <button class="btn btn-primary" onclick="window.location.reload()">Try Again</button>
        </div>
    </div>

    <!-- Main Container -->
    <div id="main-container" class="main-container hidden">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1 class="product-name" id="product-name">Product Name</h1>
                <button class="btn-icon" id="info-toggle" aria-label="Product Information">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </button>
            </div>
        </header>

        <!-- 3D Viewer Container -->
        <div class="viewer-container">
            <model-viewer
                id="model-viewer"
                alt="3D Product Model"
                shadow-intensity="1"
                shadow-softness="1"
                camera-controls
                touch-action="pan-y"
                auto-rotate
                auto-rotate-delay="3000"
                rotation-per-second="30deg"
                interaction-prompt="auto"
                interaction-prompt-style="basic"
                ar
                ar-modes="webxr scene-viewer quick-look"
                ar-scale="auto"
                ar-placement="floor"
                environment-image="neutral"
                exposure="1"
                loading="eager"
            >
                <!-- AR Button Slot -->
                <button slot="ar-button" class="ar-button" id="ar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                        <path d="M2 17l10 5 10-5"></path>
                        <path d="M2 12l10 5 10-5"></path>
                    </svg>
                    <span>View in AR</span>
                </button>

                <!-- Loading Progress -->
                <div slot="progress-bar" class="model-progress">
                    <div class="model-progress-bar" id="model-progress-bar"></div>
                </div>

                <!-- Poster while loading -->
                <div slot="poster" class="poster-container" id="poster-container">
                    <div class="poster-spinner"></div>
                </div>
            </model-viewer>

            <!-- AR Not Supported Message -->
            <div class="ar-not-supported hidden" id="ar-not-supported">
                <p>AR is not supported on this device</p>
            </div>
        </div>

        <!-- Controls Bar -->
        <div class="controls-bar">
            <button class="control-btn" id="reset-view" aria-label="Reset View">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                    <path d="M3 3v5h5"></path>
                </svg>
                <span>Reset</span>
            </button>
            <button class="control-btn" id="toggle-rotate" aria-label="Toggle Auto Rotate">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"></path>
                    <path d="M21 3v5h-5"></path>
                </svg>
                <span>Rotate</span>
            </button>
            <button class="control-btn" id="fullscreen-btn" aria-label="Toggle Fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3"></path>
                    <path d="M21 8V5a2 2 0 0 0-2-2h-3"></path>
                    <path d="M3 16v3a2 2 0 0 0 2 2h3"></path>
                    <path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>
                </svg>
                <span>Fullscreen</span>
            </button>
        </div>

        <!-- Product Info Panel -->
        <div class="info-panel hidden" id="info-panel">
            <div class="info-panel-header">
                <h2>Product Details</h2>
                <button class="btn-close" id="close-info" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="info-panel-content">
                <p class="product-description" id="product-description">Loading description...</p>
                <div class="product-meta" id="product-meta"></div>
            </div>
        </div>

        <!-- Interaction Hints -->
        <div class="hints-overlay" id="hints-overlay">
            <div class="hint-item">
                <span class="hint-icon">👆</span>
                <span>Drag to rotate</span>
            </div>
            <div class="hint-item">
                <span class="hint-icon">🤏</span>
                <span>Pinch to zoom</span>
            </div>
            <button class="btn-dismiss" id="dismiss-hints">Got it!</button>
        </div>

        <!-- Products Sidebar -->
        <div class="products-sidebar" id="products-sidebar">
            <div class="sidebar-header">
                <h3>Other Products</h3>
                <button class="btn-close" id="close-sidebar" aria-label="Close Sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="sidebar-content">
                @if(isset($otherProducts) && $otherProducts->isNotEmpty())
                    @foreach($otherProducts as $product)
                        <a href="{{ route('ar.viewer', ['productId' => $product->product_id]) }}" class="product-card-mini">
                            <div class="product-thumbnail">
                                @if($product->poster_url)
                                    <img src="{{ asset('storage/' . $product->poster_url) }}" alt="{{ $product->product_name }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                @endif
                            </div>
                            <div class="product-info-mini">
                                <h4>{{ $product->product_name }}</h4>
                                @if($product->category)
                                    <span class="category-badge">{{ $product->category }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="no-products">No other products available</p>
                @endif
            </div>
        </div>

        <!-- Sidebar Toggle Button (Mobile/Desktop) -->
        <button class="sidebar-toggle-btn" id="sidebar-toggle" aria-label="View Other Products">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Products</span>
        </button>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/ar-viewer.js') }}"></script>
    <script>
        // Initialize with product ID from URL
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id') || '{{ $productId ?? "" }}';
            
            if (productId) {
                initializeViewer(productId);
            } else {
                showError('No product ID provided. Please scan a valid QR code.');
            }
        });
    </script>
</body>
</html>
