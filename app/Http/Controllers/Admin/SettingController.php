<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityAuditLog;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('setting_value', 'setting_key')->toArray();
        $bankAccounts = SiteSetting::get('bank_accounts', []);

        return view('admin.settings.index', compact('settings', 'bankAccounts'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:100',
            'legal_entity_name' => 'required|string|max:150',
            'tax_id' => 'nullable|string|max:50',
            'contact_email' => 'required|email|max:150',
            'contact_whatsapp' => 'required|string|max:25',
            'office_address' => 'required|string',
            'business_hours' => 'nullable|string|max:100',
            'hero_badge' => 'nullable|string|max:100',
            'hero_headline' => 'required|string|max:255',
            'hero_subheadline' => 'required|string',
            'stats_projects_completed' => 'required|string|max:30',
            'stats_active_clients' => 'required|string|max:30',
            'stats_uptime_guarantee' => 'required|string|max:30',
            'stats_years_experience' => 'required|string|max:30',
            'bank_banks' => 'nullable|array',
            'bank_accounts' => 'nullable|array',
            'bank_holders' => 'nullable|array',
            'bank_branches' => 'nullable|array',
            'invoice_warranty_terms' => 'nullable|string',
            'meta_title' => 'required|string|max:200',
            'meta_description' => 'required|string|max:300',
        ]);

        $userId = Auth::id() ?? 1;

        // Save simple keys
        $simpleKeys = [
            'brand_name' => ['general', 'text'],
            'legal_entity_name' => ['billing_legal', 'text'],
            'tax_id' => ['billing_legal', 'text'],
            'contact_email' => ['contact', 'text'],
            'contact_whatsapp' => ['contact', 'text'],
            'office_address' => ['contact', 'textarea'],
            'business_hours' => ['contact', 'text'],
            'hero_badge' => ['hero', 'text'],
            'hero_headline' => ['hero', 'textarea'],
            'hero_subheadline' => ['hero', 'textarea'],
            'stats_projects_completed' => ['general', 'text'],
            'stats_active_clients' => ['general', 'text'],
            'stats_uptime_guarantee' => ['general', 'text'],
            'stats_years_experience' => ['general', 'text'],
            'invoice_warranty_terms' => ['billing_legal', 'textarea'],
            'meta_title' => ['seo', 'text'],
            'meta_description' => ['seo', 'textarea'],
        ];

        foreach ($simpleKeys as $k => $meta) {
            SiteSetting::set($k, $validated[$k] ?? '', $meta[0], $meta[1], $userId);
        }

        // Save bank accounts JSON
        $banks = [];
        if ($request->has('bank_banks') && is_array($request->bank_banks)) {
            foreach ($request->bank_banks as $i => $bank) {
                if (!empty($bank)) {
                    $banks[] = [
                        'bank' => $bank,
                        'account_number' => $request->bank_accounts[$i] ?? '',
                        'holder_name' => $request->bank_holders[$i] ?? '',
                        'branch' => $request->bank_branches[$i] ?? '',
                    ];
                }
            }
        }
        SiteSetting::set('bank_accounts', $banks, 'billing_legal', 'json', $userId);

        Cache::forget('landing_page_data');

        SecurityAuditLog::record('settings_updated', null, null, ['updated_by' => $userId]);

        return back()->with('success', 'Seluruh konfigurasi sistem dan landing page berhasil diperbarui!');
    }
}
