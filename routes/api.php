<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Product API endpoints
Route::prefix('products')->group(function () {
    // Get all products
    Route::get('/', [ProductController::class, 'index']);
    
    // Get analytics data
    Route::get('/analytics', [ProductController::class, 'analytics']);
    
    // Get specific product
    Route::get('/{productId}', [ProductController::class, 'show']);
    
    // Track product view
    Route::post('/{productId}/view', [ProductController::class, 'trackView']);
    
    // Track AR activation
    Route::post('/{productId}/ar-activation', [ProductController::class, 'trackArActivation']);
});
