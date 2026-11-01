<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SecurityAuditLog;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('demo_health_status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                    ->orWhere('product_code', 'like', "%{$s}%")
                    ->orWhere('client_or_industry', 'like', "%{$s}%");
            });
        }

        $products = $query->orderBy('sort_order')->paginate(10)->withQueryString();
        $categories = ServiceCategory::orderBy('sort_order')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ServiceCategory::orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'product_code' => 'required|string|max:30|unique:products,product_code',
            'title' => 'required|string|max:150',
            'client_or_industry' => 'nullable|string|max:100',
            'base_price' => 'nullable|numeric|min:0',
            'short_summary' => 'required|string|max:255',
            'full_description' => 'nullable|string',
            'key_features' => 'nullable|string', // newline separated
            'tech_stack' => 'nullable|string', // comma separated
            'thumbnail_path' => 'nullable|string',
            'has_live_demo' => 'boolean',
            'demo_url' => 'nullable|url|max:500',
            'demo_usage_guide' => 'nullable|string',
            'demo_roles' => 'nullable|array',
            'demo_usernames' => 'nullable|array',
            'demo_passwords' => 'nullable|array',
            'show_credentials_publicly' => 'boolean',
            'demo_reset_notice' => 'nullable|string|max:150',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $slug = Str::slug($validated['title']) . '-' . Str::lower($validated['product_code']);

        // Process features
        $features = [];
        if (!empty($validated['key_features'])) {
            $features = array_values(array_filter(array_map('trim', explode("\n", $validated['key_features']))));
        }

        // Process tech stack
        $tech = [];
        if (!empty($validated['tech_stack'])) {
            $tech = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stack']))));
        }

        // Process credentials
        $credentials = [];
        if ($request->has('demo_roles') && is_array($request->demo_roles)) {
            foreach ($request->demo_roles as $i => $role) {
                if (!empty($role)) {
                    $credentials[] = [
                        'role' => $role,
                        'username' => $request->demo_usernames[$i] ?? '',
                        'password' => $request->demo_passwords[$i] ?? '',
                    ];
                }
            }
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'product_code' => strtoupper($validated['product_code']),
            'title' => $validated['title'],
            'slug' => $slug,
            'client_or_industry' => $validated['client_or_industry'],
            'base_price' => $validated['base_price'] ?? 0,
            'short_summary' => $validated['short_summary'],
            'full_description' => $validated['full_description'],
            'key_features' => $features,
            'tech_stack' => $tech,
            'thumbnail_path' => $validated['thumbnail_path'] ?: '/assets/images/products/metani-thumb.svg',
            'has_live_demo' => $request->boolean('has_live_demo', true),
            'demo_url' => $validated['demo_url'],
            'demo_usage_guide' => $validated['demo_usage_guide'],
            'demo_credentials' => $credentials,
            'show_credentials_publicly' => $request->boolean('show_credentials_publicly', true),
            'demo_reset_notice' => $validated['demo_reset_notice'],
            'demo_health_status' => !empty($validated['demo_url']) ? 'online' : 'maintenance',
            'is_featured' => $request->boolean('is_featured', false),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('landing_page_data');

        SecurityAuditLog::record('product_created', $product, null, [
            'code' => $product->product_code,
            'title' => $product->title,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', "Produk demo '{$product->title}' berhasil ditambahkan ke katalog!");
    }

    public function edit(Product $product)
    {
        $categories = ServiceCategory::orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'product_code' => 'required|string|max:30|unique:products,product_code,' . $product->id,
            'title' => 'required|string|max:150',
            'client_or_industry' => 'nullable|string|max:100',
            'base_price' => 'nullable|numeric|min:0',
            'short_summary' => 'required|string|max:255',
            'full_description' => 'nullable|string',
            'key_features' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'thumbnail_path' => 'nullable|string',
            'has_live_demo' => 'boolean',
            'demo_url' => 'nullable|url|max:500',
            'demo_usage_guide' => 'nullable|string',
            'demo_roles' => 'nullable|array',
            'demo_usernames' => 'nullable|array',
            'demo_passwords' => 'nullable|array',
            'show_credentials_publicly' => 'boolean',
            'demo_reset_notice' => 'nullable|string|max:150',
            'demo_health_status' => 'required|in:online,maintenance,offline',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $features = [];
        if (!empty($validated['key_features'])) {
            $features = array_values(array_filter(array_map('trim', explode("\n", $validated['key_features']))));
        }

        $tech = [];
        if (!empty($validated['tech_stack'])) {
            $tech = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stack']))));
        }

        $credentials = [];
        if ($request->has('demo_roles') && is_array($request->demo_roles)) {
            foreach ($request->demo_roles as $i => $role) {
                if (!empty($role)) {
                    $credentials[] = [
                        'role' => $role,
                        'username' => $request->demo_usernames[$i] ?? '',
                        'password' => $request->demo_passwords[$i] ?? '',
                    ];
                }
            }
        }

        $oldValues = $product->only(['title', 'demo_url', 'demo_health_status', 'is_featured', 'is_active']);

        $product->update([
            'category_id' => $validated['category_id'],
            'product_code' => strtoupper($validated['product_code']),
            'title' => $validated['title'],
            'client_or_industry' => $validated['client_or_industry'],
            'base_price' => $validated['base_price'] ?? 0,
            'short_summary' => $validated['short_summary'],
            'full_description' => $validated['full_description'],
            'key_features' => $features,
            'tech_stack' => $tech,
            'thumbnail_path' => $validated['thumbnail_path'] ?: $product->thumbnail_path,
            'has_live_demo' => $request->boolean('has_live_demo', true),
            'demo_url' => $validated['demo_url'],
            'demo_usage_guide' => $validated['demo_usage_guide'],
            'demo_credentials' => $credentials,
            'show_credentials_publicly' => $request->boolean('show_credentials_publicly', true),
            'demo_reset_notice' => $validated['demo_reset_notice'],
            'demo_health_status' => $validated['demo_health_status'],
            'is_featured' => $request->boolean('is_featured', false),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Cache::forget('landing_page_data');

        SecurityAuditLog::record('product_updated', $product, $oldValues, $product->only(['title', 'demo_url', 'demo_health_status', 'is_featured', 'is_active']));

        return redirect()->route('admin.products.index')
            ->with('success', "Produk demo '{$product->title}' berhasil diperbarui!");
    }

    public function destroy(Product $product)
    {
        $title = $product->title;
        SecurityAuditLog::record('product_deleted', $product, ['title' => $title]);
        $product->delete();

        Cache::forget('landing_page_data');

        return redirect()->route('admin.products.index')
            ->with('success', "Produk demo '{$title}' telah dihapus.");
    }

    public function checkHealth(Product $product)
    {
        Artisan::call('demo:check-health', ['product_id' => $product->id]);
        $product->refresh();

        return back()->with('success', "Status domain demo diperbarui: [{$product->demo_health_status}] (HTTP {$product->last_http_code})");
    }
}
