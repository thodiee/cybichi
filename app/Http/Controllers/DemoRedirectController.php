<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DemoRedirectController extends Controller
{
    public function redirect(Request $request, string $slug): RedirectResponse
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$product || !$product->has_live_demo || empty($product->demo_url)) {
            return redirect()->route('products.show', $slug)
                ->with('error', 'Tautan demo untuk sistem ini belum tersedia atau sedang dalam pemeliharaan.');
        }

        // Increment demo click counter for business metrics
        $product->increment('demo_click_count');

        // Safe 302 redirect directly to verified demo URL
        return redirect()->away($product->demo_url);
    }
}
