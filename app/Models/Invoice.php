<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Invoice extends Model
{
    protected $fillable = [
        'uuid',
        'invoice_number',
        'client_id',
        'product_id',
        'project_title',
        'billing_type',
        'issue_date',
        'due_date',
        'subtotal',
        'discount_amount',
        'tax_percentage',
        'tax_amount',
        'grand_total',
        'amount_paid',
        'balance_due',
        'payment_status',
        'paid_at',
        'payment_method_info',
        'admin_notes',
        'verification_hash',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'paid_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_percentage' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'amount_paid' => 'decimal:2',
            'balance_due' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($invoice) {
            if (empty($invoice->uuid)) {
                $invoice->uuid = (string) Str::uuid();
            }
            if (empty($invoice->verification_hash)) {
                $invoice->verification_hash = hash('sha256', $invoice->uuid . '-' . microtime(true) . '-' . Str::random(16));
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id')->orderBy('sort_order');
    }

    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class, 'invoice_id');
    }

    public function getFormattedGrandTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->grand_total, 0, ',', '.');
    }

    public function getFormattedBalanceDueAttribute(): string
    {
        return 'Rp ' . number_format($this->balance_due, 0, ',', '.');
    }

    public function getFormattedAmountPaidAttribute(): string
    {
        return 'Rp ' . number_format($this->amount_paid, 0, ',', '.');
    }

    public function getSignedPortalUrlAttribute(): string
    {
        return url('/doc/view/' . $this->uuid);
    }

    public function getVerificationUrlAttribute(): string
    {
        return url('/verify/doc/' . $this->verification_hash);
    }

    public function getWhatsAppShareUrlAttribute(): string
    {
        if (!$this->client) {
            return '#';
        }

        $clientPhone = $this->client->clean_whatsapp;
        $clientName = $this->client->contact_name . ($this->client->company_name ? " ({$this->client->company_name})" : "");
        $docUrl = $this->signed_portal_url;
        $productTitle = $this->project_title;
        $agreement = $this->agreements()->first();
        $agreementNo = $agreement ? $agreement->agreement_number : '-';

        $text = "Yth. Bapak/Ibu {$clientName},\n\n"
            . "Terima kasih atas kepercayaan Anda kepada CYBICHI. Menindaklanjuti kesepakatan pemasangan produk/layanan *{$productTitle}*, berikut kami sampaikan tautan resmi dokumen Invoice dan Perjanjian Kerja Sama (MoU):\n\n"
            . "📄 Nomor Invoice   : {$this->invoice_number}\n"
            . ($agreement ? "📑 Nomor Perjanjian : {$agreementNo}\n" : "")
            . "📦 Produk/Layanan  : {$productTitle}\n"
            . "💳 Tagihan Saat Ini: {$this->formatted_balance_due}\n"
            . "⏳ Jatuh Tempo     : " . $this->due_date->translatedFormat('d F Y') . "\n\n"
            . "🔗 Unduh Dokumen Resmi (PDF):\n"
            . "{$docUrl}\n\n"
            . "Dokumen di atas telah terverifikasi secara digital oleh sistem CYBICHI. Silakan hubungi kami melalui chat ini apabila ada hal yang ingin dikonfirmasi. Terima kasih.";

        return "https://wa.me/{$clientPhone}?text=" . rawurlencode($text);
    }
}
