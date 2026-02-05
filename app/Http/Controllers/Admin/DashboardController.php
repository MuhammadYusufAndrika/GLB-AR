<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_views' => Product::sum('view_count'),
            'total_ar_activations' => Product::sum('ar_activation_count'),
        ];

        $recentProducts = Product::latest()->take(5)->get();
        
        $topProducts = Product::orderByDesc('view_count')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'topProducts'));
    }
}
