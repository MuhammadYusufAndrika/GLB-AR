<?php

use App\Http\Controllers\ArViewerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| WebAR Exhibition System Routes
| QR Code scans redirect users to the AR viewer page
|
*/

// Home page - Product gallery
Route::get('/', [ArViewerController::class, 'gallery'])->name('home');

// AR Viewer - Main product viewing page
Route::get('/view/{productId?}', [ArViewerController::class, 'show'])->name('ar.viewer');

// Alternative route for QR code compatibility
Route::get('/product/{productId}', [ArViewerController::class, 'show'])->name('product.view');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Admin Panel (Protected)
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Configuration check
    Route::get('/config', function () {
        return view('admin.config');
    })->name('admin.config');
    
    // Products Management
    Route::resource('products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    
    Route::get('products/{product}/download-qr', [ProductController::class, 'downloadQr'])->name('admin.products.download-qr');
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('admin.products.toggle-status');
});
