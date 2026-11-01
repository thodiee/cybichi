<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ServiceCategory;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CybichiFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SiteSetting::set('brand_name', 'CYBICHI');
        SiteSetting::set('legal_entity_name', 'PT Siber Cybichi Solusindo');

        $category = ServiceCategory::create([
            'name' => 'Web App',
            'slug' => 'web-app',
            'short_description' => 'Aplikasi web enterprise',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Product::create([
            'category_id' => $category->id,
            'product_code' => 'PRD-TEST-001',
            'slug' => 'test-product',
            'title' => 'Test Product',
            'thumbnail_path' => 'assets/images/products/metani-thumb.svg',
            'short_summary' => 'Ringkasan pengujian sistem',
            'has_live_demo' => true,
            'demo_url' => 'https://demo.cybichi.com',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
        ]);
    }

    public function test_homepage_returns_successful_response_with_security_headers(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_product_catalog_and_show_pages(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);

        $showResponse = $this->get('/products/test-product');
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Test Product');
    }

    public function test_outbound_demo_redirection(): void
    {
        $response = $this->get('/go/demo/test-product');
        $response->assertStatus(302);
        $response->assertRedirect('https://demo.cybichi.com');
    }

    public function test_admin_login_throttling_after_excessive_failures(): void
    {
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
            'is_active' => true,
        ]);

        // Attempt 5 wrong logins
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', [
                'email' => 'admin@test.com',
                'password' => 'wrong-pass',
            ]);
        }

        // 6th attempt should be blocked by rate limiter
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHas('error');
    }
}
