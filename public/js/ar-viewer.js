/**
 * WebAR Exhibition - AR Viewer JavaScript
 * Handles dynamic product loading, AR detection, and interaction tracking
 */

// API Configuration
const API_BASE_URL = "/api/products";

// State Management
let currentProduct = null;
let isAutoRotating = true;
let hasShownHints = false;

// DOM Elements
const elements = {
    loadingScreen: null,
    errorScreen: null,
    mainContainer: null,
    modelViewer: null,
    productName: null,
    productDescription: null,
    productMeta: null,
    progressBar: null,
    loadingPercent: null,
    infoPanel: null,
    hintsOverlay: null,
    arButton: null,
    arNotSupported: null,
};

/**
 * Initialize the AR Viewer with a product ID
 * @param {string} productId - The product ID to load
 */
async function initializeViewer(productId) {
    // Cache DOM elements
    cacheElements();

    try {
        // Fetch product data
        const product = await fetchProduct(productId);
        currentProduct = product;

        // Update UI with product data
        updateProductUI(product);

        // Setup model viewer
        setupModelViewer(product);

        // Track view
        trackProductView(productId);

        // Setup event listeners
        setupEventListeners();

        // Check AR support
        checkArSupport();

        // Check if hints should be shown
        checkHintsDisplay();
    } catch (error) {
        console.error("Failed to initialize viewer:", error);
        showError(error.message || "Failed to load product");
    }
}

/**
 * Cache DOM element references
 */
function cacheElements() {
    elements.loadingScreen = document.getElementById("loading-screen");
    elements.errorScreen = document.getElementById("error-screen");
    elements.mainContainer = document.getElementById("main-container");
    elements.modelViewer = document.getElementById("model-viewer");
    elements.productName = document.getElementById("product-name");
    elements.productDescription = document.getElementById(
        "product-description",
    );
    elements.productMeta = document.getElementById("product-meta");
    elements.progressBar = document.getElementById("progress-bar");
    elements.loadingPercent = document.getElementById("loading-percent");
    elements.infoPanel = document.getElementById("info-panel");
    elements.hintsOverlay = document.getElementById("hints-overlay");
    elements.arButton = document.getElementById("ar-button");
    elements.arNotSupported = document.getElementById("ar-not-supported");
}

/**
 * Fetch product data from API
 * @param {string} productId - The product ID
 * @returns {Promise<Object>} Product data
 */
async function fetchProduct(productId) {
    const response = await fetch(`${API_BASE_URL}/${productId}`);
    const data = await response.json();

    if (!response.ok || !data.success) {
        throw new Error(data.message || "Product not found");
    }

    return data.data;
}

/**
 * Update UI with product information
 * @param {Object} product - Product data
 */
function updateProductUI(product) {
    // Update page title
    document.getElementById("page-title").textContent =
        `${product.product_name} | WebAR Exhibition`;

    // Update product name
    elements.productName.textContent = product.product_name;

    // Update description
    elements.productDescription.textContent =
        product.description || "No description available.";

    // Update metadata
    if (product.metadata) {
        renderProductMeta(product.metadata);
    }

    // Update category if available
    if (product.category) {
        const categoryMeta = document.createElement("div");
        categoryMeta.className = "meta-item";
        categoryMeta.innerHTML = `
            <span class="meta-label">Category</span>
            <span class="meta-value">${product.category}</span>
        `;
        elements.productMeta.appendChild(categoryMeta);
    }
}

/**
 * Render product metadata
 * @param {Object} metadata - Product metadata
 */
function renderProductMeta(metadata) {
    Object.entries(metadata).forEach(([key, value]) => {
        const metaItem = document.createElement("div");
        metaItem.className = "meta-item";
        metaItem.innerHTML = `
            <span class="meta-label">${formatLabel(key)}</span>
            <span class="meta-value">${value}</span>
        `;
        elements.productMeta.appendChild(metaItem);
    });
}

/**
 * Format metadata label
 * @param {string} key - Metadata key
 * @returns {string} Formatted label
 */
function formatLabel(key) {
    return key
        .replace(/_/g, " ")
        .replace(/\b\w/g, (char) => char.toUpperCase());
}

/**
 * Setup model viewer with product data
 * @param {Object} product - Product data
 */
function setupModelViewer(product) {
    const modelViewer = elements.modelViewer;

    // Set model source
    modelViewer.setAttribute("src", product.model_url);

    // Set poster if available
    if (product.poster_url) {
        modelViewer.setAttribute("poster", product.poster_url);
    }

    // Set alt text
    modelViewer.setAttribute("alt", `3D model of ${product.product_name}`);

    // Loading progress handler
    modelViewer.addEventListener("progress", handleLoadingProgress);

    // Model loaded handler
    modelViewer.addEventListener("load", handleModelLoaded);

    // Error handler
    modelViewer.addEventListener("error", handleModelError);
}

/**
 * Handle loading progress
 * @param {Event} event - Progress event
 */
function handleLoadingProgress(event) {
    const progress = Math.round(event.detail.totalProgress * 100);
    elements.progressBar.style.width = `${progress}%`;
    elements.loadingPercent.textContent = `${progress}%`;

    // Update model progress bar as well
    const modelProgressBar = document.getElementById("model-progress-bar");
    if (modelProgressBar) {
        modelProgressBar.style.width = `${progress}%`;
    }
}

/**
 * Handle model loaded event
 */
function handleModelLoaded() {
    // Hide loading screen with fade animation
    elements.loadingScreen.classList.add("fade-out");

    setTimeout(() => {
        elements.loadingScreen.classList.add("hidden");
        elements.mainContainer.classList.remove("hidden");
    }, 300);

    console.log("3D model loaded successfully");
}

/**
 * Handle model loading error
 * @param {Event} event - Error event
 */
function handleModelError(event) {
    console.error("Model loading error:", event);
    showError("Failed to load 3D model. Please try again.");
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Info panel toggle
    document
        .getElementById("info-toggle")
        .addEventListener("click", toggleInfoPanel);
    document
        .getElementById("close-info")
        .addEventListener("click", closeInfoPanel);

    // Control buttons
    document.getElementById("reset-view").addEventListener("click", resetView);
    document
        .getElementById("toggle-rotate")
        .addEventListener("click", toggleAutoRotate);
    document
        .getElementById("fullscreen-btn")
        .addEventListener("click", toggleFullscreen);

    // Dismiss hints
    document
        .getElementById("dismiss-hints")
        .addEventListener("click", dismissHints);

    // AR activation tracking
    elements.modelViewer.addEventListener("ar-status", handleArStatus);

    // Close info panel on outside click
    elements.infoPanel.addEventListener("click", (e) => {
        if (e.target === elements.infoPanel) {
            closeInfoPanel();
        }
    });

    // Keyboard navigation
    document.addEventListener("keydown", handleKeydown);
}

/**
 * Toggle info panel visibility
 */
function toggleInfoPanel() {
    elements.infoPanel.classList.toggle("hidden");
    elements.infoPanel.classList.toggle("visible");
}

/**
 * Close info panel
 */
function closeInfoPanel() {
    elements.infoPanel.classList.add("hidden");
    elements.infoPanel.classList.remove("visible");
}

/**
 * Reset camera view
 */
function resetView() {
    const modelViewer = elements.modelViewer;

    // Reset camera orbit to default
    modelViewer.cameraOrbit = "auto auto auto";
    modelViewer.fieldOfView = "auto";

    // Reset camera target
    modelViewer.cameraTarget = "auto auto auto";

    // Optional: Add visual feedback
    const btn = document.getElementById("reset-view");
    btn.classList.add("active");
    setTimeout(() => btn.classList.remove("active"), 200);
}

/**
 * Toggle auto-rotate
 */
function toggleAutoRotate() {
    isAutoRotating = !isAutoRotating;
    elements.modelViewer.autoRotate = isAutoRotating;

    const btn = document.getElementById("toggle-rotate");
    btn.classList.toggle("active", isAutoRotating);
}

/**
 * Toggle fullscreen mode
 */
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch((err) => {
            console.log("Fullscreen not available:", err);
        });
    } else {
        document.exitFullscreen();
    }
}

/**
 * Check AR support
 */
async function checkArSupport() {
    const modelViewer = elements.modelViewer;

    // Wait for model-viewer to be ready
    await modelViewer.updateComplete;

    // Check if AR is available
    const arSupported = modelViewer.canActivateAR;

    if (!arSupported) {
        // Hide AR button and show not supported message
        elements.arButton.style.display = "none";
        elements.arNotSupported.classList.remove("hidden");
    }
}

/**
 * Handle AR status changes
 * @param {Event} event - AR status event
 */
function handleArStatus(event) {
    const status = event.detail.status;

    if (status === "session-started") {
        // Track AR activation
        if (currentProduct) {
            trackArActivation(currentProduct.product_id);
        }
        console.log("AR session started");
    } else if (status === "failed") {
        console.log("AR session failed");
    }
}

/**
 * Track product view
 * @param {string} productId - Product ID
 */
async function trackProductView(productId) {
    try {
        await fetch(`${API_BASE_URL}/${productId}/view`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content || "",
            },
        });
    } catch (error) {
        console.warn("Failed to track view:", error);
    }
}

/**
 * Track AR activation
 * @param {string} productId - Product ID
 */
async function trackArActivation(productId) {
    try {
        await fetch(`${API_BASE_URL}/${productId}/ar-activation`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content || "",
            },
        });
    } catch (error) {
        console.warn("Failed to track AR activation:", error);
    }
}

/**
 * Check if hints should be displayed
 */
function checkHintsDisplay() {
    const hintsShown = localStorage.getItem("ar-viewer-hints-shown");

    if (!hintsShown) {
        elements.hintsOverlay.classList.remove("hidden");
    } else {
        elements.hintsOverlay.classList.add("hidden");
    }
}

/**
 * Dismiss hints overlay
 */
function dismissHints() {
    elements.hintsOverlay.classList.add("hidden");
    localStorage.setItem("ar-viewer-hints-shown", "true");
}

/**
 * Handle keyboard navigation
 * @param {KeyboardEvent} event - Keyboard event
 */
function handleKeydown(event) {
    switch (event.key) {
        case "Escape":
            closeInfoPanel();
            break;
        case "r":
        case "R":
            resetView();
            break;
        case "f":
        case "F":
            toggleFullscreen();
            break;
        case "i":
        case "I":
            toggleInfoPanel();
            break;
    }
}

/**
 * Show error screen
 * @param {string} message - Error message
 */
function showError(message) {
    elements.loadingScreen?.classList.add("hidden");
    elements.mainContainer?.classList.add("hidden");

    const errorScreen = document.getElementById("error-screen");
    const errorMessage = document.getElementById("error-message");

    if (errorScreen && errorMessage) {
        errorMessage.textContent = message;
        errorScreen.classList.remove("hidden");
    }
}

// Export for global access
window.initializeViewer = initializeViewer;
window.showError = showError;
