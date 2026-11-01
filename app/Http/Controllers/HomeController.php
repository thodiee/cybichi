<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ServiceCategory;
use App\Models\ServicePackage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        $servicePackages = ServicePackage::with('category')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $settings = [
            'brand_name' => SiteSetting::get('brand_name', 'CYBICHI'),
            'legal_entity_name' => SiteSetting::get('legal_entity_name', 'PT Siber Cybichi Solusindo'),
            'hero_badge' => SiteSetting::get('hero_badge', 'Pusat Inovasi & Rekayasa Perangkat Lunak 2026'),
            'hero_headline' => SiteSetting::get('hero_headline', 'Transformasi Digital Korporat & Ekosistem Perangkat Lunak Terintegrasi'),
            'hero_subheadline' => SiteSetting::get('hero_subheadline', 'Mitra teknologi strategis untuk rekayasa perangkat lunak enterprise, infrastruktur jaringan berkecepatan tinggi, serta sistem informasi berstandar keamanan global.'),
            'hero_cta_demo_text' => SiteSetting::get('hero_cta_demo_text', 'Eksplorasi Live Demo'),
            'hero_cta_wa_text' => SiteSetting::get('hero_cta_wa_text', 'Konsultasi Proyek Gratis'),
            'stats_projects_completed' => SiteSetting::get('stats_projects_completed', '120+'),
            'stats_active_clients' => SiteSetting::get('stats_active_clients', '85+'),
            'stats_uptime_guarantee' => SiteSetting::get('stats_uptime_guarantee', '99.98%'),
            'stats_years_experience' => SiteSetting::get('stats_years_experience', '8+ Tahun'),
            'contact_whatsapp' => SiteSetting::get('contact_whatsapp', '081234567890'),
            'contact_email' => SiteSetting::get('contact_email', 'corporate@cybichi.com'),
            'office_address' => SiteSetting::get('office_address', "Cyber 2 Tower Lt. 18, Jl. H.R. Rasuna Said Blok X-5 No. 13\nJakarta Selatan 12950, Indonesia"),
            'business_hours' => SiteSetting::get('business_hours', 'Senin - Jumat, 08:30 - 17:30 WIB (NOC 24/7)'),
        ];

        return view('pages.home', compact('categories', 'featuredProducts', 'servicePackages', 'settings'));
    }
}
