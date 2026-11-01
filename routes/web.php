<?php

use App\Http\Controllers\Admin\AgreementController as AdminAgreementController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\DemoRedirectController;
use App\Http\Controllers\DocumentPortalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProductCatalogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes — Corporate Landing Page & Showcase
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductCatalogController::class, 'show'])->name('products.show');

// Direct Demo Outbound Tracker (New Tab Redirection & Click Analytics)
Route::get('/go/demo/{slug}', [DemoRedirectController::class, 'redirect'])->name('demo.redirect')->middleware('throttle:60,1');

// Consultation & Lead Form (Rate limited against spam bot submissions)
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store')->middleware('throttle:10,1');

// Client Signed Document Portal & PDF Downloads
Route::get('/doc/view/{uuid}', [DocumentPortalController::class, 'view'])->name('doc.view')->middleware('throttle:60,1');
Route::get('/doc/download/invoice/{uuid}', [DocumentPortalController::class, 'downloadInvoice'])->name('doc.download.invoice');
Route::get('/doc/download/agreement/{uuid}', [DocumentPortalController::class, 'downloadAgreement'])->name('doc.download.agreement');

// Official Document Authenticity Verification Portal (QR Code Target)
Route::get('/verify/doc/{hash}', [DocumentPortalController::class, 'verify'])->name('doc.verify')->middleware('throttle:60,1');

/*
|--------------------------------------------------------------------------
| Admin Back-Office Routes (Protected with Rate Limiter & Strict Auth)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Authenticated Back-Office
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products & Demo Links
        Route::resource('products', AdminProductController::class);
        Route::post('/products/{product}/check-health', [AdminProductController::class, 'checkHealth'])->name('products.check-health');

        // Clients
        Route::resource('clients', AdminClientController::class);

        // Invoices
        Route::resource('invoices', AdminInvoiceController::class);
        Route::match(['post', 'patch'], '/invoices/{invoice}/status', [AdminInvoiceController::class, 'updateStatus'])->name('invoices.status');
        Route::match(['post', 'patch'], '/invoices/{invoice}/update-status', [AdminInvoiceController::class, 'updateStatus'])->name('invoices.update-status');
        Route::get('/invoices/{invoice}/pdf', [AdminInvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
        Route::get('/invoices/{invoice}/download-pdf', [AdminInvoiceController::class, 'downloadPdf'])->name('invoices.download-pdf');

        // Agreements / MoU
        Route::resource('agreements', AdminAgreementController::class);
        Route::get('/agreements/{agreement}/pdf', [AdminAgreementController::class, 'downloadPdf'])->name('agreements.pdf');
        Route::get('/agreements/{agreement}/download-pdf', [AdminAgreementController::class, 'downloadPdf'])->name('agreements.download-pdf');

        // Inquiries / Leads Pipeline
        Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::match(['post', 'patch'], '/inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.status');

        // CMS & Legal Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::match(['post', 'put'], '/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Security Audit Logs
        Route::get('/audit-logs', [AdminAuditLogController::class, 'index'])->name('audit.index');
    });
});
