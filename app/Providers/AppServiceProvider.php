<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Schema::hasTable('site_settings')) {
                $siteSettings = [
                    'brand_name' => SiteSetting::get('brand_name', 'CYBICHI'),
                    'legal_entity_name' => SiteSetting::get('legal_entity_name', 'PT Siber Cybichi Solusindo'),
                    'tax_id' => SiteSetting::get('tax_id', '01.234.567.8-012.000'),
                    'contact_email' => SiteSetting::get('contact_email', 'corporate@cybichi.com'),
                    'contact_whatsapp' => SiteSetting::get('contact_whatsapp', '081234567890'),
                    'office_address' => SiteSetting::get('office_address', "Cyber 2 Tower Lt. 18, Jl. H.R. Rasuna Said Blok X-5 No. 13\nJakarta Selatan 12950, Indonesia"),
                    'business_hours' => SiteSetting::get('business_hours', 'Senin - Jumat, 08:30 - 17:30 WIB (NOC 24/7)'),
                ];
                $view->with('siteSettings', $siteSettings);
            }

            if (Schema::hasTable('products')) {
                $footerProducts = Product::where('is_active', true)
                    ->orderBy('sort_order')
                    ->take(6)
                    ->get(['id', 'title', 'slug']);
                $view->with('footerProducts', $footerProducts);
            }
        });
    }
}
