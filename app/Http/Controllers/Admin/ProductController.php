<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'model_file' => ['required', 'file', 'mimes:glb,gltf', 'max:51200'], // Max 50MB
            'poster_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // Max 5MB
        ]);

        // Generate unique product ID
        $productId = 'PROD-' . strtoupper(Str::random(8));

        // Upload 3D model file
        $modelPath = $request->file('model_file')->store('models', 'public');

        // Upload poster image if provided
        $posterPath = null;
        if ($request->hasFile('poster_file')) {
            $posterPath = $request->file('poster_file')->store('posters', 'public');
        }

        // Create product
        $product = Product::create([
            'product_id' => $productId,
            'product_name' => $validated['product_name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'model_url' => $modelPath,
            'poster_url' => $posterPath,
            'is_active' => true,
        ]);

        // Generate QR code
        $this->generateQrCode($product);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Product created successfully! QR code generated.');
    }

    /**
     * Display the specified product with QR code.
     */
    public function show(Product $product): View
    {
        $viewerUrl = route('ar.viewer', ['productId' => $product->product_id]);
        
        
        $qrCode = QrCode::size(300)
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->margin(2)
            ->generate($viewerUrl);

        return view('admin.products.show', compact('product', 'qrCode', 'viewerUrl'));
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }
    

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'model_file' => ['nullable', 'file', 'mimes:glb,gltf', 'max:51200'],
            'poster_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['boolean'],
        ]);

        // Update model file if new one uploaded
        if ($request->hasFile('model_file')) {
            // Delete old file
            if ($product->model_url) {
                Storage::disk('public')->delete($product->model_url);
            }
            $validated['model_url'] = $request->file('model_file')->store('models', 'public');
        }

        // Update poster if new one uploaded
        if ($request->hasFile('poster_file')) {
            // Delete old file
            if ($product->poster_url) {
                Storage::disk('public')->delete($product->poster_url);
            }
            $validated['poster_url'] = $request->file('poster_file')->store('posters', 'public');
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->boolean('is_active');

        // Remove file inputs from validated data
        unset($validated['model_file'], $validated['poster_file']);

        $product->update($validated);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Delete associated files
        if ($product->model_url) {
            Storage::disk('public')->delete($product->model_url);
        }
        if ($product->poster_url) {
            Storage::disk('public')->delete($product->poster_url);
        }
        if ($product->qr_code_url) {
            Storage::disk('public')->delete($product->qr_code_url);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Download QR code for the product.
     */
    public function downloadQr(Product $product)
    {
        $viewerUrl = route('ar.viewer', ['productId' => $product->product_id]);
        
        $qrCode = QrCode::size(500)
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->margin(2)
            ->format('svg')
            ->generate($viewerUrl);

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-' . $product->product_id . '.svg"');
    }

    /**
     * Toggle product active status.
     */
    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Product {$status} successfully!");
    }

    /**
     * Generate and save QR code for a product.
     */
    protected function generateQrCode(Product $product): void
    {
        $viewerUrl = route('ar.viewer', ['productId' => $product->product_id]);
        
        $qrCode = QrCode::size(500)
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->margin(2)
            ->format('svg')
            ->generate($viewerUrl);

        $qrPath = 'qrcodes/' . $product->product_id . '.svg';
        Storage::disk('public')->put($qrPath, $qrCode);

        $product->update(['qr_code_url' => $qrPath]);
    }
}
