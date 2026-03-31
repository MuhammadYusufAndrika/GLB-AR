<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::active()
            ->select(['id', 'product_id', 'product_name', 'description', 'category', 'poster_url'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    
    public function show(string $productId): JsonResponse
    {
        $product = Product::active()
            ->where('product_id', $productId)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'model_url' => $product->model_full_url,
                'poster_url' => $product->poster_full_url,
                'qr_code_url' => $product->qr_code_url,
                'category' => $product->category,
                'metadata' => $product->metadata,
            ],
        ]);
    }

    /**
     * Track a product view.
     */
    public function trackView(string $productId): JsonResponse
    {
        $product = Product::where('product_id', $productId)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->incrementViews();

        return response()->json([
            'success' => true,
            'message' => 'View tracked successfully',
        ]);
    }

    /**
     * Track AR activation.
     */
    public function trackArActivation(string $productId): JsonResponse
    {
        $product = Product::where('product_id', $productId)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->incrementArActivations();

        return response()->json([
            'success' => true,
            'message' => 'AR activation tracked successfully',
        ]);
    }

    /**
     * Get analytics for all products.
     */
    public function analytics(): JsonResponse
    {
        $products = Product::select([
            'product_id',
            'product_name',
            'view_count',
            'ar_activation_count',
        ])->get();

        $totalViews = $products->sum('view_count');
        $totalArActivations = $products->sum('ar_activation_count');

        return response()->json([
            'success' => true,
            'data' => [
                'total_views' => $totalViews,
                'total_ar_activations' => $totalArActivations,
                'products' => $products,
            ],
        ]);
    }
}
