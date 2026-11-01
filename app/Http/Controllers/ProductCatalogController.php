<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $queryKeyword = trim($request->query('q', ''));
        $sort = $request->query('sort', 'default');

        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $productsQuery = Product::with('category')
            ->where('is_active', true);

        if ($categorySlug) {
            $productsQuery->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($queryKeyword !== '') {
            $productsQuery->where(function ($q) use ($queryKeyword) {
                $q->where('title', 'like', "%{$queryKeyword}%")
                    ->orWhere('product_code', 'like', "%{$queryKeyword}%")
                    ->orWhere('short_summary', 'like', "%{$queryKeyword}%")
                    ->orWhere('client_or_industry', 'like', "%{$queryKeyword}%")
                    ->orWhereJsonContains('tech_stack', $queryKeyword);
            });
        }

        if ($sort === 'popular') {
            $productsQuery->orderByDesc('demo_click_count');
        } elseif ($sort === 'newest') {
            $productsQuery->orderByDesc('created_at');
        } else {
            $productsQuery->orderByDesc('is_featured')->orderBy('sort_order');
        }

        $products = $productsQuery->paginate(9)->withQueryString();

        return view('pages.products.index', compact('products', 'categories', 'categorySlug', 'queryKeyword', 'sort'));
    }

    public function show(string $slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count
        $product->increment('view_count');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('pages.products.show', compact('product', 'relatedProducts'));
    }
}
