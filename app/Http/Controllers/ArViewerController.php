<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArViewerController extends Controller
{
    /**
     * Display the AR viewer page.
     * 
     * @param Request $request
     * @param string|null $productId
     * @return View
     */
    public function show(Request $request, ?string $productId = null): View
    {
        // Get product ID from route parameter or query string
        $productId = $productId ?? $request->query('id');

        // Fetch other active products for sidebar navigation
        $otherProducts = Product::active()
            ->where('product_id', '!=', $productId)
            ->select(['product_id', 'product_name', 'category', 'poster_url'])
            ->latest()
            ->take(10)
            ->get();

        return view('ar-viewer', [
            'productId' => $productId,
            'otherProducts' => $otherProducts,
        ]);
    }

    /**
     * Display the product gallery page.
     * 
     * @return View
     */
    public function gallery(): View
    {
        $products = Product::active()
            ->select(['id', 'product_id', 'product_name', 'description', 'category', 'poster_url'])
            ->get();

        return view('gallery', [
            'products' => $products,
        ]);
    }
}
