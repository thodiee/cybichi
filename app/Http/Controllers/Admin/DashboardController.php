<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalDemoClicks = Product::sum('demo_click_count');
        $onlineDemos = Product::where('has_live_demo', true)->where('demo_health_status', 'online')->count();
        $maintenanceDemos = Product::where('has_live_demo', true)->where('demo_health_status', 'maintenance')->count();

        $totalClients = Client::count();
        $totalInquiries = Inquiry::count();
        $newInquiries = Inquiry::where('status', 'new')->count();

        $totalInvoices = Invoice::count();
        $paidRevenue = Invoice::sum('amount_paid');
        $pendingReceivables = Invoice::whereIn('payment_status', ['unpaid', 'partial_dp', 'overdue'])->sum('balance_due');
        $totalContractsValue = Agreement::sum('contract_value');
        $activeAgreements = Agreement::where('status', 'signed_active')->orWhere('status', 'issued')->count();

        $recentInvoices = Invoice::with(['client', 'product'])
            ->latest()
            ->take(5)
            ->get();

        $recentInquiries = Inquiry::with('product')
            ->latest()
            ->take(5)
            ->get();

        $topDemoProducts = Product::orderByDesc('demo_click_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalDemoClicks',
            'onlineDemos',
            'maintenanceDemos',
            'totalClients',
            'totalInquiries',
            'newInquiries',
            'totalInvoices',
            'paidRevenue',
            'pendingReceivables',
            'totalContractsValue',
            'activeAgreements',
            'recentInvoices',
            'recentInquiries',
            'topDemoProducts'
        ));
    }
}
